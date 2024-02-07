"use strict";(self.webpackChunkdocs=self.webpackChunkdocs||[]).push([[45],{5406:(e,t,n)=>{n.r(t),n.d(t,{assets:()=>h,contentTitle:()=>d,default:()=>y,frontMatter:()=>l,metadata:()=>c,toc:()=>u});var r=n(5893),a=n(1151);const o=n.p+"assets/images/new-product-ca0520a841e12363ea6f90cc9fc3c648.png",i=n.p+"assets/images/new-plan-6a8d1bc3e1ad70b7a6eb42a01fcb1a89.png",s=n.p+"assets/images/plan-pricing-47d4cf7598368fd55e66857c8487dc2a.png",l={title:"Products, Plans and Pricing",sidebar_position:3},d=void 0,c={id:"products-plans-and-pricing",title:"Products, Plans and Pricing",description:"SaaSykit comes with support for a customizable product management system that allows you to create multiple products, each with multiple plans, and each plan can have multiple intervals (monthly, yearly, etc), prices, and features.",source:"@site/docs/products-plans-and-pricing.md",sourceDirName:".",slug:"/products-plans-and-pricing",permalink:"/docs/products-plans-and-pricing",draft:!1,unlisted:!1,tags:[],version:"current",sidebarPosition:3,frontMatter:{title:"Products, Plans and Pricing",sidebar_position:3},sidebar:"tutorialSidebar",previous:{title:"Helpers",permalink:"/docs/development/helpers"},next:{title:"Discounts",permalink:"/docs/discounts"}},h={},u=[{value:"Products",id:"products",level:2},{value:"Plans",id:"plans",level:2},{value:"Trial Period",id:"trial-period",level:3},{value:"Pricing",id:"pricing",level:3},{value:"Common Product/Plan Setups",id:"common-productplan-setups",level:2},{value:"&quot;Basic&quot;, &quot;Pro&quot; and &quot;Ultimate&quot; Products with Monthly and Yearly Plans",id:"basic-pro-and-ultimate-products-with-monthly-and-yearly-plans",level:3},{value:"&quot;Starter&quot; and &quot;Growth&quot; Products with Monthly, Quarterly and Yearly Plans (with trial periods)",id:"starter-and-growth-products-with-monthly-quarterly-and-yearly-plans-with-trial-periods",level:3},{value:"&quot;Free&quot; and &quot;Pro&quot; Products with Monthly and Yearly Plans (with trial period)",id:"free-and-pro-products-with-monthly-and-yearly-plans-with-trial-period",level:3},{value:"Upgrading/Downgrading Plans",id:"upgradingdowngrading-plans",level:2},{value:"Displaying plans on your site",id:"displaying-plans-on-your-site",level:2}];function p(e){const t={a:"a",admonition:"admonition",code:"code",h2:"h2",h3:"h3",li:"li",ol:"ol",p:"p",strong:"strong",ul:"ul",...(0,a.a)(),...e.components};return(0,r.jsxs)(r.Fragment,{children:[(0,r.jsxs)(t.p,{children:[(0,r.jsx)(t.strong,{children:"SaaSykit"})," comes with support for a customizable product management system that allows you to create multiple products, each with multiple plans, and each plan can have multiple intervals (monthly, yearly, etc), prices, and features."]}),"\n",(0,r.jsx)(t.h2,{id:"products",children:"Products"}),"\n",(0,r.jsxs)(t.p,{children:["A ",(0,r.jsx)(t.strong,{children:"product"}),' is a collection of plans that you offer to your customers. For example, you can have a product called "Basic" that has a monthly plan and a yearly plan. You can also have a product called "Pro" that has a monthly plan and a yearly plan.']}),"\n",(0,r.jsxs)(t.p,{children:["Each product can have a set of metadata that you define in the Admin Panel that is accessible to your application via a helper function. You can use this metadata to store information about the product that you want to access in your application. For example, you can store the number of users allowed in the product, and then use the helper function ",(0,r.jsx)(t.a,{href:"/docs/development/helpers#subscriptionmanagergetusersubscriptionproductmetadata",children:"SubscriptionManager::getUserSubscriptionProductMetadata()"})," to access that information in your application and display it to your users or check against it."]}),"\n",(0,r.jsx)(t.p,{children:"For example, if you are offering an API access to your customers where you allow different number of requests per product, you can store that information in the product metadata and then use it in your application to check against it."}),"\n",(0,r.jsx)(t.p,{children:"This offers a lot of flexibility and allows you to customize your product offering to your customers and have this data in centralized place."}),"\n",(0,r.jsxs)(t.p,{children:["To create a new product, go to the Admin Panel and under ",(0,r.jsx)(t.strong,{children:'"Product Management"'})," click on ",(0,r.jsx)(t.strong,{children:'"Products"'}),", then click on ",(0,r.jsx)(t.strong,{children:'"New Product"'}),". You will be redirected to the create product page."]}),"\n",(0,r.jsx)("img",{src:o,alt:"New product",width:"800",class:"image"}),"\n",(0,r.jsx)(t.p,{children:"You need to enter the following information about your new product:"}),"\n",(0,r.jsxs)(t.ul,{children:["\n",(0,r.jsxs)(t.li,{children:[(0,r.jsx)(t.strong,{children:"Name"}),": The name of the product."]}),"\n",(0,r.jsxs)(t.li,{children:[(0,r.jsx)(t.strong,{children:"Slug"}),": The slug of the product. This will be generated automatically based on the name, but you can change it if you want."]}),"\n",(0,r.jsxs)(t.li,{children:[(0,r.jsx)(t.strong,{children:"Description"}),": The description of the product."]}),"\n",(0,r.jsxs)(t.li,{children:[(0,r.jsx)(t.strong,{children:"Popular Product"}),": Whether this product is popular or not. This will be used to display the product as the ",(0,r.jsx)(t.strong,{children:'"most popular"'})," product in the ",(0,r.jsx)(t.a,{href:"/docs/components/plans",children:"plans component"}),"."]}),"\n",(0,r.jsxs)(t.li,{children:[(0,r.jsx)(t.strong,{children:"Is default product"}),': Whether this product is the default product or not. Default products will be assigned to users who are not subscribed to any product/plan. They are basically a virtual container to the "metadata" that you want to assign to users who are not subscribed to any product/plan.\n',(0,r.jsx)("br",{}),(0,r.jsx)("br",{}),'For example, if you are building an image generation service and want to offer your non-subscribed users a 50 image generations per month as a free tier, then you can create a product called "Free" and set it as the default product, and then assign a metadata to it called "image_generations" and set it to 50. Then you can use the helper function ',(0,r.jsx)(t.a,{href:"/docs/development/helpers#subscriptionmanagergetusersubscriptionproductmetadata",children:"SubscriptionManager::getUserSubscriptionProductMetadata()"})," to access this metadata in your application and check against it."]}),"\n"]}),"\n",(0,r.jsx)(t.admonition,{type:"info",children:(0,r.jsx)(t.p,{children:"You can only have one default product at a time."})}),"\n",(0,r.jsxs)(t.ul,{children:["\n",(0,r.jsxs)(t.li,{children:[(0,r.jsx)(t.strong,{children:"Metadata"}),": The metadata of the product. This is a JSON object that you can use to store any information you want about the product. For example, you can store the number of users allowed in the product, and then use ",(0,r.jsx)(t.a,{href:"/docs/development/helpers#subscriptionmanagergetusersubscriptionproductmetadata",children:"SubscriptionManager::getUserSubscriptionProductMetadata()"})," to access that information in your application and display it to your users or check against it."]}),"\n",(0,r.jsxs)(t.li,{children:[(0,r.jsx)(t.strong,{children:"Features"}),": The features of the product. These will be displayed during checkout and in the ",(0,r.jsx)(t.a,{href:"/docs/components/plans",children:"plans component"})," to show the features of each plan to your users."]}),"\n"]}),"\n",(0,r.jsx)(t.h2,{id:"plans",children:"Plans"}),"\n",(0,r.jsxs)(t.p,{children:["A ",(0,r.jsx)(t.strong,{children:"plan"}),' is a time period (time interval) at which you want your product to be billed (monthly, yearly, etc). For example, you might have a product called "Basic" that has a monthly plan called ',(0,r.jsx)(t.code,{children:"Basic Monthly"})," (with a monthly interval) and a yearly plan called ",(0,r.jsx)(t.code,{children:"Basic Yearly"}),' (with a yearly interval). This means that your customers will be able to subscribe to your "Basic" product and choose to be billed either monthly or yearly.']}),"\n",(0,r.jsxs)(t.p,{children:["To create a new plan, go to the Admin Panel and under ",(0,r.jsx)(t.strong,{children:'"Product Management"'})," click on ",(0,r.jsx)(t.strong,{children:'"Plans"'}),", then click on ",(0,r.jsx)(t.strong,{children:'"New Plan"'}),". You will be redirected to the create plan page."]}),"\n",(0,r.jsx)("img",{src:i,alt:"New plan",width:"800",class:"image"}),"\n",(0,r.jsx)(t.p,{children:"You need to enter the following information about your new plan:"}),"\n",(0,r.jsxs)(t.ul,{children:["\n",(0,r.jsxs)(t.li,{children:[(0,r.jsx)(t.strong,{children:"Name"}),": The name of the plan."]}),"\n",(0,r.jsxs)(t.li,{children:[(0,r.jsx)(t.strong,{children:"Slug"}),": The slug of the plan. This will be generated automatically based on the name, but you can change it if you want."]}),"\n",(0,r.jsxs)(t.li,{children:[(0,r.jsx)(t.strong,{children:"Product"}),": The product that this plan belongs to (select from the dropdown)."]}),"\n",(0,r.jsxs)(t.li,{children:[(0,r.jsx)(t.strong,{children:"Interval Count"}),": The number of intervals (months, years, etc) that this plan will be billed at. For example, if you want to bill the customer every 3 months, then you need to set this to ",(0,r.jsx)(t.code,{children:"3"})," and the interval (see below) to ",(0,r.jsx)(t.code,{children:"month"}),"."]}),"\n",(0,r.jsxs)(t.li,{children:[(0,r.jsx)(t.strong,{children:"Interval"}),": The interval (monthly, yearly, etc) that this plan will be billed at."]}),"\n",(0,r.jsxs)(t.li,{children:[(0,r.jsx)(t.strong,{children:"Has trial"}),": Whether this plan has a trial period or not. If this is enabled, then you need to set the trial period for this plan (see below)."]}),"\n",(0,r.jsxs)(t.li,{children:[(0,r.jsx)(t.strong,{children:"Trial interval count"}),": The number of intervals (months, years, etc) that the trial period will last. For example, if you want to offer a 3 months trial period, then you need to set this to ",(0,r.jsx)(t.code,{children:"3"})," and the trial interval (see below) to ",(0,r.jsx)(t.code,{children:"month"}),"."]}),"\n",(0,r.jsxs)(t.li,{children:[(0,r.jsx)(t.strong,{children:"Trial interval"}),": The interval (monthly, yearly, etc) that the trial period will last."]}),"\n",(0,r.jsxs)(t.li,{children:[(0,r.jsx)(t.strong,{children:"Is Active"}),": Whether this plan is active or not. If this is disabled, then this plan will not be displayed in the ",(0,r.jsx)(t.a,{href:"/docs/components/plans",children:"plans component"})," and will not be available for your users to subscribe to."]}),"\n",(0,r.jsxs)(t.li,{children:[(0,r.jsx)(t.strong,{children:"Description"}),": The description of the plan."]}),"\n"]}),"\n",(0,r.jsx)(t.h3,{id:"trial-period",children:"Trial Period"}),"\n",(0,r.jsx)(t.p,{children:"As mentioned above, you can define a trial period (interval) for each plan. This allows you to offer a trial period for your customers to try your product before they are billed for it."}),"\n",(0,r.jsx)(t.p,{children:"This is useful if you want to offer a free trial period for your customers to try your product before they are billed for it."}),"\n",(0,r.jsx)(t.h3,{id:"pricing",children:"Pricing"}),"\n",(0,r.jsx)(t.p,{children:"Each plan can have multiple prices. You can define pricing for each plan while editing the plan in the Admin Panel."}),"\n",(0,r.jsx)("img",{src:s,alt:"Plan pricing",width:"800",class:"image"}),"\n",(0,r.jsxs)(t.admonition,{type:"info",children:[(0,r.jsxs)(t.p,{children:[(0,r.jsx)(t.strong,{children:"SaaSykit"})," allows you to define multiple prices for each plan but does not allow for switching prices at checkout page yet. Your users can only pay in the ",(0,r.jsx)(t.code,{children:"Default Currency"})," that you defined on the ",(0,r.jsx)(t.a,{href:"/docs/settings",children:"settings"})," page."]}),(0,r.jsx)(t.p,{children:"Supporting multiple prices at checkout will be added in the future."})]}),"\n",(0,r.jsx)(t.h2,{id:"common-productplan-setups",children:"Common Product/Plan Setups"}),"\n",(0,r.jsx)(t.h3,{id:"basic-pro-and-ultimate-products-with-monthly-and-yearly-plans",children:'"Basic", "Pro" and "Ultimate" Products with Monthly and Yearly Plans'}),"\n",(0,r.jsx)(t.p,{children:"To achieve this setup:"}),"\n",(0,r.jsxs)(t.ol,{children:["\n",(0,r.jsxs)(t.li,{children:["Create three products: ",(0,r.jsx)(t.code,{children:"Basic"}),", ",(0,r.jsx)(t.code,{children:"Pro"})," and ",(0,r.jsx)(t.code,{children:"Ultimate"}),"."]}),"\n",(0,r.jsxs)(t.li,{children:["For each product, you need to create two plans: one with a monthly interval (",(0,r.jsx)(t.code,{children:"Basic Monthly"}),") and one with a yearly interval ",(0,r.jsx)(t.code,{children:"Basic Yearly"}),"."]}),"\n",(0,r.jsx)(t.li,{children:"Add pricing for the plans that you created in the previous step as you see fit."}),"\n"]}),"\n",(0,r.jsx)(t.h3,{id:"starter-and-growth-products-with-monthly-quarterly-and-yearly-plans-with-trial-periods",children:'"Starter" and "Growth" Products with Monthly, Quarterly and Yearly Plans (with trial periods)'}),"\n",(0,r.jsx)(t.p,{children:"To achieve this setup:"}),"\n",(0,r.jsxs)(t.ol,{children:["\n",(0,r.jsxs)(t.li,{children:["Create two products: ",(0,r.jsx)(t.code,{children:"Starter"})," and ",(0,r.jsx)(t.code,{children:"Growth"}),"."]}),"\n",(0,r.jsxs)(t.li,{children:["For each product, you need to create three plans: one with a monthly interval (",(0,r.jsx)(t.code,{children:"Starter Monthly"})," & ",(0,r.jsx)(t.code,{children:"Growth Monthly"}),"), one with a quarterly interval (",(0,r.jsx)(t.code,{children:"Starter Quarterly"})," & ",(0,r.jsx)(t.code,{children:"Growth Quarterly"}),"), and one with a yearly interval (",(0,r.jsx)(t.code,{children:"Starter Yearly"})," & ",(0,r.jsx)(t.code,{children:"Growth Yearly"}),")."]}),"\n"]}),"\n",(0,r.jsx)(t.admonition,{type:"tip",children:(0,r.jsxs)(t.p,{children:["To create the ",(0,r.jsx)(t.strong,{children:"Quarterly"})," plan, you need to set the ",(0,r.jsx)(t.code,{children:"Interval Count"})," to ",(0,r.jsx)(t.code,{children:"3"})," and the ",(0,r.jsx)(t.code,{children:"Interval"})," to ",(0,r.jsx)(t.code,{children:"month"}),"."]})}),"\n",(0,r.jsx)(t.p,{children:"Define the trial period for each plan as you see fit."}),"\n",(0,r.jsxs)(t.ol,{start:"3",children:["\n",(0,r.jsx)(t.li,{children:"Add pricing for the plans that you created in the previous step as you see fit."}),"\n"]}),"\n",(0,r.jsx)(t.h3,{id:"free-and-pro-products-with-monthly-and-yearly-plans-with-trial-period",children:'"Free" and "Pro" Products with Monthly and Yearly Plans (with trial period)'}),"\n",(0,r.jsx)(t.p,{children:"To achieve this setup:"}),"\n",(0,r.jsxs)(t.ol,{children:["\n",(0,r.jsxs)(t.li,{children:["Create two products: ",(0,r.jsx)(t.code,{children:"Free"})," and ",(0,r.jsx)(t.code,{children:"Pro"}),". When creating the ",(0,r.jsx)(t.code,{children:"Free"})," product, make sure to set it as the ",(0,r.jsx)(t.code,{children:"default"})," product. This will make it the default product that is selected when the user is not subscribed to any product/plan."]}),"\n",(0,r.jsxs)(t.li,{children:["For the ",(0,r.jsx)(t.code,{children:"Pro"})," product you need to create two plans: one with a monthly interval (",(0,r.jsx)(t.code,{children:"Pro Monthly"}),") and one with a yearly interval (",(0,r.jsx)(t.code,{children:"Pro Yearly"}),"). Define the trial period for the ",(0,r.jsx)(t.code,{children:"Pro"})," plan as you see fit."]}),"\n"]}),"\n",(0,r.jsx)(t.admonition,{type:"tip",children:(0,r.jsxs)(t.p,{children:["For the ",(0,r.jsx)(t.code,{children:"Free"}),' product you don\'t need to create any plans. This will serve as a virtual container to the "metadata" that you want to assign to users who are not subscribed to any product/plan.']})}),"\n",(0,r.jsxs)(t.ol,{start:"3",children:["\n",(0,r.jsxs)(t.li,{children:["Add pricing for the ",(0,r.jsx)(t.code,{children:"Pro"})," plans that you created in the previous step as you see fit."]}),"\n"]}),"\n",(0,r.jsx)(t.h2,{id:"upgradingdowngrading-plans",children:"Upgrading/Downgrading Plans"}),"\n",(0,r.jsxs)(t.p,{children:[(0,r.jsx)(t.strong,{children:"SaaSykit"})," allows your users to upgrade/downgrade their plans at any time through the ",(0,r.jsx)(t.a,{href:"user-dashboard",children:"user dashboard"}),"."]}),"\n",(0,r.jsx)(t.p,{children:"This will save your precious time and allow your users to manage their subscriptions without having to contact you."}),"\n",(0,r.jsx)(t.admonition,{type:"tip",children:(0,r.jsxs)(t.p,{children:["You can adjust how ",(0,r.jsx)(t.a,{href:"/docs/payment-providers#proration",children:"pro-rations"})," are handled (how your customer should be billed when they upgrade/downgrade) in the ",(0,r.jsx)(t.a,{href:"/docs/settings",children:"settings"})," page."]})}),"\n",(0,r.jsx)(t.h2,{id:"displaying-plans-on-your-site",children:"Displaying plans on your site"}),"\n",(0,r.jsxs)(t.p,{children:[(0,r.jsx)(t.strong,{children:"SaaSykit"})," comes handy with the magical \u2728",(0,r.jsx)(t.a,{href:"/docs/components/plans",children:"plans component"})," that you can use to display the plans that you offer on your site in 1 line of code."]})]})}function y(e={}){const{wrapper:t}={...(0,a.a)(),...e.components};return t?(0,r.jsx)(t,{...e,children:(0,r.jsx)(p,{...e})}):p(e)}},1151:(e,t,n)=>{n.d(t,{Z:()=>s,a:()=>i});var r=n(7294);const a={},o=r.createContext(a);function i(e){const t=r.useContext(o);return r.useMemo((function(){return"function"==typeof e?e(t):{...t,...e}}),[t,e])}function s(e){let t;return t=e.disableParentContext?"function"==typeof e.components?e.components(a):e.components||a:i(e.components),r.createElement(o.Provider,{value:t},e.children)}}}]);