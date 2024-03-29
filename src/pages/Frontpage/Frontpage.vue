/**
 * @license GPL-2.0-or-later
 */

<script>
/**
 * Serves the front page data and components
 * @displayName Frontpage
 */
import {mapGetters} from "vuex";
import ContributionMap from "../ContributionMap/ContributionMap.vue";
import ContributionList from "../ContributionList/ContributionList.vue";
import ProjectInfo from "../ProjectInfo/ProjectInfo.vue";
import SchedulePage from "../Schedule/SchedulePage.vue";
import StatisticsPage from "../Statistics/StatisticsPage.vue";
import ConceptionList from "../ConceptionList/ConceptionList.vue";
import SurveyPage from "../Survey/SurveyPage.vue";
import CustomPage from "../CustomPage/CustomPage.vue";

export default {
  name: "Frontpage",
  components: {
    ContributionMap,
    ContributionList,
    ProjectInfo,
    SchedulePage,
    StatisticsPage,
    ConceptionList,
    SurveyPage,
    CustomPage
  },
  data () {
    return {
      pageContent: {}
    };
  },
  computed: {
    ...mapGetters([
      "frontpage"
    ]),
    htmlPageTitle () {
      switch (this.frontpage) {
        case "contributionlist":
          return this.$t("ContributionList.title");
        case "projectinfo":
          return this.pageContent.title;
        case "schedule":
          return this.$t("Schedule.title");
        case "statistics":
          return this.$t("Statistics.headline");
        case "conceptionlist":
          return this.pageContent.title;
        case "survey":
          return this.pageContent.title;
        case "custompage":
          return this.pageContent.title;
        case "contributionmap":
        default:
          return this.$t("ContributionMap.title");
      }
    },
    component () {
      switch (this.frontpage) {
        case "contributionlist":
          return ContributionList;
        case "projectinfo":
          return ProjectInfo;
        case "schedule":
          return SchedulePage;
        case "statistics":
          return StatisticsPage;
        case "conceptionlist":
          return ConceptionList;
        case "survey":
          return SurveyPage;
        case "custompage":
          return CustomPage;
        case "contributionmap":
        default:
          return ContributionMap;
      }
    }
  }
};
</script>

<template>
  <component
    :is="component"
    :key="component.name"
    :content="pageContent"
  />
</template>

<style>
    #app.mobile section.content.frontpageWithoutBorder {
        padding: 0;
    }

    .map_frontpage {
        padding: 10px;
    }

    #app.desktop section.frontpage div.map_frontpage,
    #app.desktop section.frontpage div.map_frontpage iframe#contribution_map {
        height: 100%
    }

    #app.desktop section.frontpage .buttonWrapper {
        display: flex;
        height: 0;
    }

    #app.desktop section.frontpage .buttonWrapper .dipasButton {
        width: 300px;
        position: relative;
        top: -100px;
        margin: 0 auto;
    }

    #app.desktop section.frontpage .buttonWrapper .dipasButton .customIcon {
        margin: 0 0.5rem 0.3rem 0;
    }

    #app.mobile section.frontpage div.map_frontpage,
    #app.mobile section.frontpage div.map_frontpage iframe#contribution_map {
        padding: 0;
        height: calc(100vh - 150px);
    }
</style>
