/**
 * @license GPL-2.0-or-later
 */

<script>
/**
 * The contribution modal component to create a new post.
 * @displayName CreateContributionModal
 */

/* eslint-disable no-fallthrough */
/* eslint-disable default-case */
import {requestBroker} from "../mixins/requestBroker.js";
import CreateContributionModalStepIndicator from "./CreateContributionModalStepIndicator.vue";
import CreateContributionModalStepContents from "./CreateContributionModalStepContents.vue";
import DipasButton from "./DipasButton.vue";
import JSum from "jsum";

export default {
  /**
   * More Informations for CreateContributionModal is described here.
   *
   * @example ./doc/documentation.md
   */
  name: "CreateContributionModal",
  components: {
    DipasButton,
    CreateContributionModalStepIndicator,
    CreateContributionModalStepContents
  },
  mixins: [requestBroker],
  data () {
    // Look for predefined geodata in the query of the url
    let geodata = false;

    if (this.$route.query.lat !== undefined && this.$route.query.lon !== undefined) {
      geodata = {
        "type": "Feature",
        "geometry": {
          "type": "Point",
          "coordinates": [parseFloat(this.$route.query.lon), parseFloat(this.$route.query.lat)]
        },
        "properties": {
          "styleID": "",
          "centerPoint": {
            "type": "Point",
            "coordinates": [parseFloat(this.$route.query.lon), parseFloat(this.$route.query.lat)]
          }
        }
      };
    }
    return {
      step: 1,
      headlineMinLength: 5,
      contributionMinLength: 10,
      textChecksum: false,
      contributionData: {
        step1: {
          headline: "",
          text: "",
          headlineMinLength: 5,
          contributionMinLength: 10
        },
        step2: {
          category: 0,
          token: "",
          proposals: [],
          abandonedProposals: [],
          selectedKeywords: []
        },
        step3: {
          rubric: 0
        },
        step4: {
          geodata: geodata ? JSON.stringify(geodata) : "{}"
        }
      },
      stepvalue: {},
      saving: false
    };
  },
  computed: {
    contributionMustBeLocalized () {
      return this.$store.getters.contributionsMustBeLocalized;
    },
    /**
     * @name useRubrics
     * @returns {Boolean}
     */
    useRubrics () {
      return this.$store.getters.useRubrics;
    },
    /**
     * @name backButtonDisabled
     * @returns {Boolean}
     */
    backButtonDisabled () {
      return this.saving;
    },
    /**
     * @name nextButtonDisabled
     * @returns {Boolean}
     */
    nextButtonDisabled () {
      switch (this.step) {
        case 1:
          if (
            this.step === 1 &&
                            this.contributionData.step1.headline.length >= this.headlineMinLength &&
                            this.contributionData.step1.text.length >= this.contributionMinLength
          ) {
            return false;
          }
        case 2:
          if (
            this.step === 2 &&
                            this.contributionData.step2.category !== 0
          ) {
            return false;
          }
        case 3:
          if (
            this.step === 3 &&
                            ((this.useRubrics && this.contributionData.step3.rubric !== 0) ||
                            !this.useRubrics)
          ) {
            return false;
          }
        case 4:
          if (
            this.step === 4 && !(this.contributionMustBeLocalized && !Object.keys(JSON.parse(this.contributionData.step4.geodata)).length)
          ) {
            return false;
          }
        case 5:
          if (
            this.step === 5 &&
                            !this.saving
          ) {
            return false;
          }
        default:
          return true;
      }
    }
  },
  watch: {
    step (val) {
      if (val < 5) {
        this.stepvalue = Object.assign({}, this.contributionData["step" + val]);
      }
      else {
        this.stepvalue = Object.assign({}, this.contributionData);
      }
    },
    stepvalue: {
      deep: true,
      handler: function (val) {
        this.contributionData["step" + this.step] = Object.assign({}, val);
      }
    }
  },
  created () {
    this.stepvalue = Object.assign({}, this.contributionData.step1);
  },
  beforeDestroy () {
    this.contributionData = {};
  },
  mounted () {
    const focusableElements = "button, [href], input, select, textarea, [tabindex]:not([tabindex='-1'])",
      modal = document.querySelector("#modalWizard"),
      firstFocusableElement = modal.querySelectorAll(focusableElements)[0],
      focusableContent = modal.querySelectorAll(focusableElements),
      lastFocusableElement = focusableContent[focusableContent.length - 1];

    modal.focus();
    document.addEventListener("keydown", function (e) {
      const isTabPressed = e.key === "Tab" || e.keyCode === 9;

      if (!isTabPressed) {
        return;
      }

      if (e.shiftKey) {
        if (document.activeElement === firstFocusableElement) {
          lastFocusableElement.focus();
          e.preventDefault();
        }
      }
      else if (document.activeElement === lastFocusableElement) {
        firstFocusableElement.focus();
        e.preventDefault();
      }
    });
  },
  methods: {
    /**
     * Sets the step value one times backward or trigger the CreateContributionModal
     * @public
     * @returns {void}
     */
    backAction () {
      if (this.step > 1) {
        this.step--;
      }
      else {
        this.$root.showCreateContributionModal = false;
      }
    },
    /**
     * Renders the step specific form
     * @public
     * @returns {void}
     */
    nextAction () {
      switch (this.step) {
        case 1:
          if (this.$store.getters.isKeywordServiceEnabled && (this.textChecksum === false || this.textChecksum !== JSum.digest(this.contributionData.step1.text, "SHA256", "hex"))) {
            this.contributionData.step2.referenceKeywordList = [];
            this.contributionData.step2.keywords = [];
            this.contributionData.step2.proposals = [];
            this.contributionData.step2.abandonedProposals = [];
            this.textChecksum = JSum.digest(this.contributionData.step1.text, "SHA256", "hex");
            this.requestKeywords({description: this.contributionData.step1.text});
          }
        case 2:
        case 3:
        case 4:
          this.step++;
          break;
        case 5:
          this.saving = true;
          this.saveContribution({
            title: this.contributionData.step1.headline,
            text: this.contributionData.step1.text,
            keywords: this.contributionData.step2.selectedKeywords,
            token: this.contributionData.step2.token,
            category: this.contributionData.step2.category,
            rubric: this.contributionData.step3.rubric,
            geodata: this.contributionData.step4.geodata
          });
          break;
      }
    },
    /**
     * Saves the step value
     * @param {Number} step Step of wizard
     * @public
     * @returns {void}
     */
    jumpTo (step) {
      this.step = Number(step);
    }
  }
};
</script>

<template>
  <!--
    @name ModalElement
    @fire closeModal
  -->
  <ModalElement
    id="modalWizard"
    class="createContributionModal"
    @closeModal="$root.showCreateContributionModal = false"
  >
    <div class="createWizard">
      <!--
        @name CreateContributionModalStepIndicator
        @fire jumpTo
      -->
      <CreateContributionModalStepIndicator
        :activeStep="step"
        @jumpTo="jumpTo"
      />
      <!--
        @name CreateContributionModalStepContents
        @fire jumpTo
      -->
      <CreateContributionModalStepContents
        v-model="stepvalue"
        :class="'step' + step"
        :activeStep="step"
        :value="contributionData[step]"
        :useRubrics="useRubrics"
        @jumpTo="jumpTo"
      />

      <div class="actions">
        <!--
          @name DipasButton
          @fire click backAction
        -->
        <DipasButton
          :text="step === 1 ? $t('CreateContributionModal.cancel') : $t('CreateContributionModal.backward')"
          :icon="step > 1 ? 'chevron_left' : ''"
          class="angular grey"
          :disabled="backButtonDisabled"
          @click="backAction"
        />
        <!--
          @name DipasButton
          @fire click nextAction
        -->
        <DipasButton
          :text="step < 5 ? $t('CreateContributionModal.forward') : $t('CreateContributionModal.complete')"
          icon="chevron_right"
          iconposition="right"
          class="angular"
          :class="nextButtonDisabled ? 'darkgrey' : 'red'"
          :disabled="nextButtonDisabled"
          @click="nextAction"
        />
      </div>
    </div>
  </ModalElement>
</template>

<style>
    div.createContributionModal div.createWizard {
        width: 700px;
    }

    #app.mobile div.createContributionModal div.createWizard {
        width: 100%;
        height: calc((var(--vh, 1vh) * 100) - 60px);
        display: flex;
        flex-direction: column;
    }

    #app.mobile div.createContributionModal div.createWizard ul.createContributionStepIndicator {
        height: 12px;
        flex: 1 1 0%;
    }

    div.createContributionModal div.createWizard div.actions {
        display: flex;
        flex-flow: row;
        justify-content: space-between;
        margin-top: 1rem;
        position: sticky;
        bottom: 5px;
        z-index: 100;
     }

    div.createContributionModal div.createWizard .infoTextZuKurz{
        line-height: 1rem;
        font-size: 0.8rem;
        color: #595959;
        display: inline-block;
        padding-bottom: 1rem;
    }

    div.createContributionModal div.createWizard div.infoTextZuKurz{
        width: 100%;
        text-align: left;
    }

    #app.mobile div.createContributionModal div.createWizard div.createContributionStep {
        flex: 20 1 0%;
    }

    #app.mobile div.createContributionModal div.createWizard div.createContributionStep.step1 {
        height: auto;
    }

    #app.mobile div.createContributionModal div.createWizard div.actions {
        margin-top:15px;
        flex: 1 1 0%;
    }

    div.createContributionModal div.createWizard div.actions button {
        display: inline-block;
        width: auto;
        height: 40px;
        padding: 10px 30px;
    }

    div.createContributionModal div.createWizard div.actions button.dipasButton .customIcon {
        font-size: 1.625rem;
        vertical-align: middle;
        font-weight: normal;
    }

    div.createContributionModal div.createWizard div.actions button.dipasButton .customIcon.left {
        margin-right: -5px;
        padding-bottom:2px;
    }

    div.createContributionModal div.createWizard div.actions button.dipasButton .customIcon.right {
        margin-left: -5px;
        padding-bottom:2px;
    }
</style>
