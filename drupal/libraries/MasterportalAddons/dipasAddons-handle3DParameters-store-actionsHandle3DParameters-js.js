(window.webpackJsonp=window.webpackJsonp||[]).push([[416],{3455:function(p,D,s){(function(o,m){var P=Object.create,n=Object.defineProperty,g=Object.getOwnPropertyDescriptor,d=Object.getOwnPropertyNames,h=Object.getPrototypeOf,v=Object.prototype.hasOwnProperty,f=(e,r)=>{for(var a in r)n(e,a,{get:r[a],enumerable:!0})},l=(e,r,a,i)=>{if(r&&typeof r=="object"||typeof r=="function")for(let t of d(r))!v.call(e,t)&&t!==a&&n(e,t,{get:()=>r[t],enumerable:!(i=g(r,t))||i.enumerable});return e},_=(e,r,a)=>(a=e!=null?P(h(e)):{},l(r||!e||!e.__esModule?n(a,"default",{value:e,enumerable:!0}):a,e)),C=e=>l(n({},"__esModule",{value:!0}),e),u={};f(u,{default:()=>M}),p.exports=C(u);var c=_(s(1907)),M={setCameraViaURLParameters({rootState:e}){var r,a,i;if(e.urlParams&&e.urlParams.cameraPosition!==void 0){const t=(r=e.urlParams)!=null&&r.cameraPosition?e.urlParams.cameraPosition:void 0,O=(a=e.urlParams)!=null&&a.cameraPitch?e.urlParams.cameraPitch:void 0,w=(i=e.urlParams)!=null&&i.cameraHeading?e.urlParams.cameraHeading:void 0,b=c.default.getMap("3D").getCesiumScene().camera,y=Cesium.Cartesian3.fromDegrees(t[0],t[1],t[2]);b.flyTo({destination:y,orientation:{heading:w,pitch:O},easingFunction:Cesium.EasingFunction.QUADRATIC_OUT})}},setMapViewListerner({rootGetters:e},r){o.Events.listenTo(m.channel("MapView"),{changedCenter:function(){if(e["Maps/mode"]==="3D"){const a=c.default.getMap("3D").getCesiumScene().camera,i=Cesium.Cartographic.fromCartesian(a.position);r.vm.$remoteInterface.sendMessage({cameraPosition:[i.longitude/Math.PI*180,i.latitude/Math.PI*180,i.height],cameraHeading:a.heading,cameraPitch:a.pitch})}}}),o.Events.listenTo(m.channel("Map"),{change:function(){if(e["Maps/mode"]==="3D"){const a=c.default.getMap("3D").getCesiumScene().camera,i=Cesium.Cartographic.fromCartesian(a.position);r.vm.$remoteInterface.sendMessage({cameraPosition:[i.longitude/Math.PI*180,i.latitude/Math.PI*180,i.height],cameraHeading:a.heading,cameraPitch:a.pitch})}}})}}}).call(this,s(10),s(2))}}]);
