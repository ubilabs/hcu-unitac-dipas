(window.webpackJsonp=window.webpackJsonp||[]).push([[406,404,407],{3315:function(P,E,b){var l=Object.defineProperty,i=Object.getOwnPropertyDescriptor,d=Object.getOwnPropertyNames,f=Object.prototype.hasOwnProperty,y=(p,s)=>{for(var o in s)l(p,o,{get:s[o],enumerable:!0})},w=(p,s,o,r)=>{if(s&&typeof s=="object"||typeof s=="function")for(let a of d(s))!f.call(p,a)&&a!==o&&l(p,a,{get:()=>s[a],enumerable:!(r=i(s,a))||r.enumerable});return p},u=p=>w(l({},"__esModule",{value:!0}),p),v={};y(v,{emptyStoryConf:()=>g,htmlEditorToolbar:()=>j,storyCreationViews:()=>O,storyTellingModeIcons:()=>m,storyTellingModes:()=>_}),P.exports=u(v);const _={CREATE:"create",PLAY:"play"},m={[_.CREATE]:"add",[_.PLAY]:"play_arrow"},O={STORY_CREATION:"story",STEP_CREATION:"step",PREVIEW:"preview"},g={chapters:[],steps:[]},j=[[{header:[!1,1,2,3,4,5,6]}],["bold","italic","underline","strike"],[{align:""},{align:"center"},{align:"right"},{align:"justify"}],[{list:"ordered"},{list:"bullet"}],["blockquote","code-block"],[{color:[]},{background:[]}],["link","image"],["clean"]]},3316:function(P,E,b){var l=Object.defineProperty,i=Object.getOwnPropertyDescriptor,d=Object.getOwnPropertyNames,f=Object.getOwnPropertySymbols,y=Object.prototype.hasOwnProperty,w=Object.prototype.propertyIsEnumerable,u=(o,r,a)=>r in o?l(o,r,{enumerable:!0,configurable:!0,writable:!0,value:a}):o[r]=a,v=(o,r)=>{for(var a in r||(r={}))y.call(r,a)&&u(o,a,r[a]);if(f)for(var a of f(r))w.call(r,a)&&u(o,a,r[a]);return o},_=(o,r)=>{for(var a in r)l(o,a,{get:r[a],enumerable:!0})},m=(o,r,a,N)=>{if(r&&typeof r=="object"||typeof r=="function")for(let c of d(r))!y.call(o,c)&&c!==a&&l(o,c,{get:()=>r[c],enumerable:!(N=i(r,c))||N.enumerable});return o},O=o=>m(l({},"__esModule",{value:!0}),o),g={};_(g,{default:()=>s}),P.exports=O(g);var j=b(3315),s={id:"dataNarrator",storyConf:v({},j.emptyStoryConf),htmlContents:{},htmlContentsImages:{},autoplay:!1,active:!1,keepOpen:!0,name:"Story Telling Tool",glyphicon:"glyphicon-book",renderToWindow:!0,resizableWindow:!0,isVisibleInMenu:!0,deactivateGFI:!1,initialWidth:500,initialWidthMobile:300,storyInterval:null}},3344:function(P,E,b){var l=Object.create,i=Object.defineProperty,d=Object.defineProperties,f=Object.getOwnPropertyDescriptor,y=Object.getOwnPropertyDescriptors,w=Object.getOwnPropertyNames,u=Object.getOwnPropertySymbols,v=Object.getPrototypeOf,_=Object.prototype.hasOwnProperty,m=Object.prototype.propertyIsEnumerable,O=(t,e,n)=>e in t?i(t,e,{enumerable:!0,configurable:!0,writable:!0,value:n}):t[e]=n,g=(t,e)=>{for(var n in e||(e={}))_.call(e,n)&&O(t,n,e[n]);if(u)for(var n of u(e))m.call(e,n)&&O(t,n,e[n]);return t},j=(t,e)=>d(t,y(e)),p=(t,e)=>{for(var n in e)i(t,n,{get:e[n],enumerable:!0})},s=(t,e,n,T)=>{if(e&&typeof e=="object"||typeof e=="function")for(let h of w(e))!_.call(t,h)&&h!==n&&i(t,h,{get:()=>e[h],enumerable:!(T=f(e,h))||T.enumerable});return t},o=(t,e,n)=>(n=t!=null?l(v(t)):{},s(e||!t||!t.__esModule?i(n,"default",{value:t,enumerable:!0}):n,t)),r=t=>s(i({},"__esModule",{value:!0}),t),a={};p(a,{default:()=>C}),P.exports=r(a);var N=b(7),c=o(b(3316)),C=j(g({},(0,N.generateSimpleMutations)(c.default)),{applyTranslationKey:(t,e)=>{e&&e.indexOf("translate#")>-1&&(t.name=e.substr(10))}})}}]);