(window.webpackJsonp=window.webpackJsonp||[]).push([[3],{572:function(e,t,i){"use strict";i.r(t);var s=i(577),a={name:"TaskCard",props:{values:Object},mounted:function(){this.bindValues()},data:function(){return{status:"Complete",date:"2020-09-23",title:"Recruit and onboard 20 new interns for the summer program",assigneeLabel:"Assigned to",assigneeImage:"https://images.unsplash.com/photo-1586367751368-99141fd186a0?ixlib=rb-1.2.1&q=80&fm=jpg&crop=entropy&cs=tinysrgb&w=1080&fit=max&ixid=eyJhcHBfaWQiOjE2MTY1fQ",assigneeName:"Frank Abel",reviewersLabel:"Reviewers Label",reviewers:["https://images.unsplash.com/photo-1542513217-0b0eedf7005d?ixlib=rb-1.2.1&q=80&fm=jpg&crop=entropy&cs=tinysrgb&w=1080&fit=max&ixid=eyJhcHBfaWQiOjE2MTY1fQ","https://images.unsplash.com/photo-1546672741-d327539d5f13?ixlib=rb-1.2.1&q=80&fm=jpg&crop=entropy&cs=tinysrgb&w=1080&fit=max&ixid=eyJhcHBfaWQiOjE2MTY1fQ","https://images.unsplash.com/photo-1587492520470-8cea42e7b7fe?ixlib=rb-1.2.1&q=80&fm=jpg&crop=entropy&cs=tinysrgb&w=1080&fit=max&ixid=eyJhcHBfaWQiOjE2MTY1fQ"]}},computed:{noStatus:function(){return!this.status||!this.status.length},noDate:function(){return!this.date||!this.date.length},noTitle:function(){return!this.title||!this.title.length},noAssigneeImage:function(){return!this.assigneeImage||!this.assigneeImage.length},noAssigneeName:function(){return!this.assigneeName||!this.assigneeName.length},noReviewers:function(){return!this.reviewers||!this.reviewers.length},noCard:function(){return this.noStatus&&!this.noDate&&!this.noTitle&&!this.noAssigneeImage&&!this.noAssigneeName&&!this.noReviewers}},watch:{values:{deep:!0,handler:function(){this.bindValues()}}},methods:{bindValues:function(){if(this.values){var e=this.values,t=e.status,i=e.date,s=e.title,a=e.assigneeLabel,n=e.assigneeImage,r=e.assigneeName,l=e.reviewersLabel,o=e.reviewers;this.status=t,this.date=i,this.title=s,this.assigneeLabel=a,this.assigneeImage=n,this.assigneeName=r,this.reviewersLabel=l,this.reviewers=o}}},components:{PierCardHeading:s.b,PierCardDate:s.a,PierCardMiniProfile:s.c}},n=(i(585),i(1)),r=Object(n.a)(a,(function(){var e=this,t=e.$createElement,i=e._self._c||t;return i("div",{staticClass:"PierCard TaskCard rounded-lg overflow-hidden bg-white text-black p-5"},[e.noStatus&&e.noDate?e._e():i("div",{staticClass:"flex justify-between items-center"},[e.noStatus?e._e():i("div",{staticClass:"mb-3 flex items-center"},[i("span",{staticClass:"rounded-full px-3 py-1 bg-green-200 text-green-900 white font-bold uppercase text-sm tracking-wider"},[e._v("\n        "+e._s(e.status)+"\n      ")])]),e._v(" "),e.noDate?e._e():i("PierCardDate",{attrs:{icon:"event",date:e.date}})],1),e._v(" "),e.noTitle?e._e():i("PierCardHeading",{attrs:{heading:e.title,headingSize:"2xl"}}),e._v(" "),(e.noAssigneeImage||e.noAssigneeName)&&e.noReviewers?e._e():i("div",{staticClass:"flex justify-between mt-4"},[e.noAssigneeImage||e.noAssigneeName?e._e():i("div",[i("span",{staticClass:"tracking-widest uppercase text-sm text-gray-700 inline-block mb-2"},[e._v("\n        "+e._s(e.assigneeLabel)+"\n      ")]),e._v(" "),e.noAssigneeImage||e.noAssigneeName?e._e():i("PierCardMiniProfile",{attrs:{name:e.assigneeName,image:e.assigneeImage}})],1),e._v(" "),e.noReviewers?e._e():i("div",[i("span",{staticClass:"tracking-widest uppercase text-sm text-gray-700 inline-block mb-2"},[e._v("\n        "+e._s(e.reviewersLabel)+"\n      ")]),e._v(" "),i("div",{staticClass:"flex items-center"},[i("div",{staticClass:"flex items-center"},e._l(e.reviewers.slice(0,3),(function(e,t){return i("div",{key:t,staticClass:"relative flex-shrink-0 w-10 h-10 border-4 border-white bg-grey-500 rounded-full -mr-3"},[i("img",{staticClass:"absolute pin rounded-full object-cover w-full h-full",attrs:{src:e,alt:""}})])})),0),e._v(" "),e.reviewers.length>3?i("span",{staticClass:"text-lg text-gray-700 ml-3"},[e._v("\n          +"+e._s(e.reviewers.length-3)+"\n        ")]):e._e()])])])],1)}),[],!1,null,null,null);t.default=r.exports},576:function(e,t,i){"use strict";var s={name:"PierCardHeading",props:{heading:{type:String,default:"The trouble with always withering onwards, part II"},subHeading:{type:String}}},a=i(1),n=Object(a.a)(s,(function(){var e=this,t=e.$createElement,i=e._self._c||t;return i("div",[i("h3",{staticClass:"text-2xl mb-1 font-bold leading-tight"},[e._v("\n    "+e._s(e.heading)+"\n  ")]),e._v(" "),e.subHeading&&e.subHeading.length?i("p",{staticClass:"mb-3 text-lg"},[e._v("\n    "+e._s(e.subHeading)+"\n  ")]):e._e()])}),[],!1,null,null,null);t.a=n.exports},577:function(e,t,i){"use strict";i.d(t,"b",(function(){return s.a})),i.d(t,"c",(function(){return r})),i.d(t,"a",(function(){return d}));var s=i(576),a={name:"PierCardMiniProfile",props:{image:{type:String,default:"https://images.unsplash.com/photo-1551069613-1904dbdcda11?ixlib=rb-1.2.1&q=80&fm=jpg&crop=entropy&cs=tinysrgb&w=1080&fit=max&ixid=eyJhcHBfaWQiOjE2MTY1fQ"},name:{type:String,default:"Agnes Mng'one"},position:{type:String}},computed:{hidePosition:function(){return!this.position||!this.position.length}}},n=i(1),r=Object(n.a)(a,(function(){var e=this,t=e.$createElement,i=e._self._c||t;return i("div",{staticClass:"flex items-center"},[i("div",{staticClass:"hidde relative flex-shrink-0 bg-grey-500 rounded-full",class:{"w-12 h-12 mr-3":!e.hidePosition,"w-8 h-8 mr-2":e.hidePosition}},[i("img",{staticClass:"absolute pin rounded-full object-cover w-full h-full",attrs:{src:e.image,alt:""}})]),e._v(" "),i("div",[i("h5",{staticClass:"text-lg",class:{"font-bold":!e.hidePosition}},[e._v("\n        "+e._s(e.name)+"\n      ")]),e._v(" "),e.hidePosition?e._e():i("p",{staticClass:"capitalize text-gray-800"},[e._v(e._s(e.position))])])])}),[],!1,null,null,null).exports,l=i(35),o=i(49),c={name:"PierCardDate",props:{icon:{type:String},date:{type:String},startDate:{type:String,default:"2020-07-22"},startTime:{type:String,default:"16:30:00"},endDate:{type:String,default:"2020-07-22"},endTime:{type:String,default:"18:00:00"}},computed:{dateString:function(){if(this.date&&this.date.length)return this.formattedDate(this.date.split(" ")[0]);var e="",t=this.startDate,i=this.startTime,s=this.endDate,a=this.endTime,n={},r={};if(t&&this.formattedDate(t)&&(n.date=this.formattedDate(t)),i&&this.formattedTime(i)&&(n.time=this.formattedTime(i)),s&&this.formattedDate(s)&&(r.date=this.formattedDate(s)),a&&this.formattedTime(a)&&(r.time=this.formattedTime(a)),n.date){if(t!==s&&s&&r.date)if(t.split("-")[1]==s.split("-")[1]){e=n.date.split(" ")[0]+" - ";var l=r.date.split(" ");3===l.length?(l.splice(1,1),e+=l.join(" ").trim()):e+=l.slice(0,2).join(" ").trim(),n.time&&(e+=", from ".concat(n.time))}else e="".concat(n.date," - ").concat(r.date),n.time&&(e+=", from ".concat(n.time));else e=n.date,n.time&&(e+=", ".concat(n.time),r.time&&(e+=" - ".concat(r.time)));return e}}},methods:{formattedDate:function(e){try{var t=Object(o.a)(e,"yyyy-MM-dd",new Date),i=Object(l.a)(new Date(t),"do MMM yyyy");return i.replace(" ".concat((new Date).getFullYear()),"")}catch(t){return console.log("Error formatting: ".concat(e),t),null}},formattedTime:function(e){try{var t=Object(o.a)(e,"HH:mm:ss",new Date);return Object(l.a)(new Date(t),"hh:mm a")}catch(e){return!1}}}},d=Object(n.a)(c,(function(){var e=this.$createElement,t=this._self._c||e;return t("div",{staticClass:"mb-3 flex items-center"},[t("span",{staticClass:"text-gray-500"},["event"===this.icon?t("svg",{staticClass:"mr-3 w-5",attrs:{fill:"currentColor",viewBox:"0 0 24 24"}},[t("path",{attrs:{d:"M17 12h-5v5h5v-5zM16 1v2H8V1H6v2H5c-1.11 0-1.99.9-1.99 2L3 19c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2h-1V1h-2zm3 18H5V8h14v11z"}})]):t("svg",{staticClass:"mr-3 w-5",attrs:{fill:"currentColor",viewBox:"0 0 24 24"}},[t("path",{attrs:{d:"M11.99 2C6.47 2 2 6.48 2 12s4.47 10 9.99 10C17.52 22 22 17.52 22 12S17.52 2 11.99 2zM12 20c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8z"}}),t("path",{attrs:{d:"M12.5 7H11v6l5.25 3.15.75-1.23-4.5-2.67z"}})])]),this._v(" "),t("span",{staticClass:"text-lg text-gray-700"},[this._v("\n    "+this._s(this.dateString)+"\n  ")])])}),[],!1,null,null,null).exports},580:function(e,t,i){var s=i(586);"string"==typeof s&&(s=[[e.i,s,""]]);var a={hmr:!0,transform:void 0,insertInto:void 0};i(10)(s,a);s.locals&&(e.exports=s.locals)},585:function(e,t,i){"use strict";i(580)},586:function(e,t,i){(e.exports=i(9)(!1)).push([e.i,"\n.TaskCard h3.text-2xl{\n  line-height: 1.4;\n  font-size: 1.6rem;\n}\n",""])}}]);