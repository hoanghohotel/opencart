# Bản đồ source code

Commit khảo sát: `7fcbe3b27bb7ac04e10895f9d5a64fa964659fbe`. Đây là inventory tĩnh theo declaration/literal, không phải call graph runtime.

## Phạm vi

3590 file tracked được đọc và băm SHA-256; 1548 file PHP được quét declaration/reference, trong đó 435 file không nằm trong vendor. Phân tích thủ công sâu tập trung entrypoint, engine, startup, auth, marketplace, checkout/payment, order, admin CRUD và SQL. Không khẳng định đã kiểm chứng ngữ nghĩa từng nhánh của toàn bộ thư viện bên thứ ba.

## Class và method ngoài vendor

| File | Class / namespace | Method khai báo |
|---|---|---|
| [admin/config-dist.php:1](../../admin/config-dist.php#L1) |   |  |
| [admin/config.php:1](../../admin/config.php#L1) |   |  |
| [admin/controller/cloud/subscription.php:1](../../admin/controller/cloud/subscription.php#L1) |  ControllerCloudSubscription | `index()`, `add()`, `edit()`, `delete()`, `getFilterUrl()`, `getList()`, `getForm()`, `validateForm()`, `validateDelete()` |
| [admin/controller/cms/blog.php:1](../../admin/controller/cms/blog.php#L1) |  ControllerCmsBlog | `index()`, `add()`, `edit()`, `delete()`, `getList()`, `getForm()`, `validateForm()`, `validateDelete()` |
| [admin/controller/cms/blog_category.php:1](../../admin/controller/cms/blog_category.php#L1) |  ControllerCmsBlogCategory | `index()`, `add()`, `edit()`, `delete()`, `getList()`, `getForm()`, `validateForm()`, `validateDelete()` |
| [admin/controller/cms/blog_comment.php:1](../../admin/controller/cms/blog_comment.php#L1) |  ControllerCmsBlogComment | `index()`, `edit()`, `approve()`, `delete()`, `getList()`, `getForm()`, `validateForm()`, `validateDelete()` |
| [admin/controller/cms/download.php:1](../../admin/controller/cms/download.php#L1) |  ControllerCmsDownload | `index()`, `add()`, `edit()`, `delete()`, `getList()`, `getForm()`, `validateForm()`, `validateDelete()` |
| [admin/controller/cms/information.php:1](../../admin/controller/cms/information.php#L1) |  ControllerCmsInformation | `index()`, `add()`, `edit()`, `delete()`, `getList()`, `getForm()`, `validateForm()`, `validateDelete()` |
| [admin/controller/cms/showcase.php:1](../../admin/controller/cms/showcase.php#L1) |  ControllerCmsShowcase | `index()`, `add()`, `edit()`, `delete()`, `getList()`, `getForm()`, `validateForm()`, `validateDelete()` |
| [admin/controller/common/column_left.php:1](../../admin/controller/common/column_left.php#L1) |  ControllerCommonColumnLeft | `index()` |
| [admin/controller/common/dashboard.php:1](../../admin/controller/common/dashboard.php#L1) |  ControllerCommonDashboard | `index()` |
| [admin/controller/common/developer.php:1](../../admin/controller/common/developer.php#L1) |  ControllerCommonDeveloper | `index()`, `edit()`, `theme()`, `sass()` |
| [admin/controller/common/filemanager.php:1](../../admin/controller/common/filemanager.php#L1) |  ControllerCommonFileManager | `index()`, `upload()`, `folder()`, `delete()` |
| [admin/controller/common/footer.php:1](../../admin/controller/common/footer.php#L1) |  ControllerCommonFooter | `index()` |
| [admin/controller/common/forgotten.php:1](../../admin/controller/common/forgotten.php#L1) |  ControllerCommonForgotten | `index()`, `validate()` |
| [admin/controller/common/header.php:1](../../admin/controller/common/header.php#L1) |  ControllerCommonHeader | `index()` |
| [admin/controller/common/login.php:1](../../admin/controller/common/login.php#L1) |  ControllerCommonLogin | `index()`, `validate()` |
| [admin/controller/common/logout.php:1](../../admin/controller/common/logout.php#L1) |  ControllerCommonLogout | `index()` |
| [admin/controller/common/profile.php:1](../../admin/controller/common/profile.php#L1) |  ControllerCommonProfile | `index()`, `validateForm()` |
| [admin/controller/common/reset.php:1](../../admin/controller/common/reset.php#L1) |  ControllerCommonReset | `index()`, `validate()` |
| [admin/controller/common/security.php:1](../../admin/controller/common/security.php#L1) |  ControllerCommonSecurity | `index()`, `move()` |
| [admin/controller/design/banner.php:1](../../admin/controller/design/banner.php#L1) |  ControllerDesignBanner | `index()`, `add()`, `edit()`, `delete()`, `getList()`, `getForm()`, `validateForm()`, `validateDelete()` |
| [admin/controller/design/seo_url.php:1](../../admin/controller/design/seo_url.php#L1) |  ControllerDesignSeoUrl | `index()`, `add()`, `edit()`, `delete()`, `getList()`, `getForm()`, `validateForm()`, `validateDelete()` |
| [admin/controller/error/not_found.php:1](../../admin/controller/error/not_found.php#L1) |  ControllerErrorNotFound | `index()` |
| [admin/controller/error/permission.php:1](../../admin/controller/error/permission.php#L1) |  ControllerErrorPermission | `index()` |
| [admin/controller/event/language.php:1](../../admin/controller/event/language.php#L1) |  ControllerEventLanguage | `index()`, `before()`, `after()` |
| [admin/controller/event/statistics.php:1](../../admin/controller/event/statistics.php#L1) |  ControllerEventStatistics | `removeReview()`, `removeReturn()` |
| [admin/controller/event/theme.php:1](../../admin/controller/event/theme.php#L1) |  ControllerEventTheme | `index()` |
| [admin/controller/localisation/country.php:1](../../admin/controller/localisation/country.php#L1) |  ControllerLocalisationCountry | `index()`, `add()`, `edit()`, `delete()`, `getList()`, `getForm()`, `validateForm()`, `validateDelete()`, `country()` |
| [admin/controller/localisation/currency.php:1](../../admin/controller/localisation/currency.php#L1) |  ControllerLocalisationCurrency | `index()`, `add()`, `edit()`, `delete()`, `refresh()`, `getList()`, `getForm()`, `validateForm()`, `validateDelete()`, `validateRefresh()` |
| [admin/controller/localisation/language.php:1](../../admin/controller/localisation/language.php#L1) |  ControllerLocalisationLanguage | `index()`, `add()`, `edit()`, `delete()`, `getList()`, `getForm()`, `validateForm()`, `validateDelete()` |
| [admin/controller/localisation/order_status.php:1](../../admin/controller/localisation/order_status.php#L1) |  ControllerLocalisationOrderStatus | `index()`, `add()`, `edit()`, `delete()`, `getList()`, `getForm()`, `validateForm()`, `validateDelete()` |
| [admin/controller/localisation/zone.php:1](../../admin/controller/localisation/zone.php#L1) |  ControllerLocalisationZone | `index()`, `add()`, `edit()`, `delete()`, `getList()`, `getForm()`, `validateForm()`, `validateDelete()` |
| [admin/controller/mail/affiliate.php:1](../../admin/controller/mail/affiliate.php#L1) |  ControllerMailAffiliate | `approve()`, `deny()` |
| [admin/controller/mail/customer.php:1](../../admin/controller/mail/customer.php#L1) |  ControllerMailCustomer | `approve()`, `deny()` |
| [admin/controller/mail/forgotten.php:1](../../admin/controller/mail/forgotten.php#L1) |  ControllerMailForgotten | `index()` |
| [admin/controller/mail/return.php:1](../../admin/controller/mail/return.php#L1) |  ControllerMailReturn | `index()` |
| [admin/controller/mail/reward.php:1](../../admin/controller/mail/reward.php#L1) |  ControllerMailReward | `index()` |
| [admin/controller/mail/transaction.php:1](../../admin/controller/mail/transaction.php#L1) |  ControllerMailTransaction | `index()` |
| [admin/controller/marketplace/category.php:1](../../admin/controller/marketplace/category.php#L1) |  ControllerMarketplaceCategory | `index()`, `add()`, `edit()`, `delete()`, `getList()`, `getForm()`, `validateForm()`, `validateDelete()` |
| [admin/controller/marketplace/comment.php:1](../../admin/controller/marketplace/comment.php#L1) |  ControllerMarketplaceComment | `index()`, `edit()`, `approve()`, `delete()`, `getList()`, `getForm()`, `validateForm()`, `validateDelete()` |
| [admin/controller/marketplace/extension.php:1](../../admin/controller/marketplace/extension.php#L1) |  ControllerMarketplaceExtension | `index()`, `add()`, `edit()`, `delete()`, `getFilterUrl()`, `getList()`, `getForm()`, `validateForm()`, `validateDelete()` |
| [admin/controller/marketplace/promotion.php:1](../../admin/controller/marketplace/promotion.php#L1) |  ControllerMarketplacePromotion | `index()`, `add()`, `edit()`, `delete()`, `getList()`, `getForm()`, `validateForm()`, `validateDelete()` |
| [admin/controller/member/member.php:1](../../admin/controller/member/member.php#L1) |  ControllerMemberMember | `index()`, `add()`, `edit()`, `delete()`, `getList()`, `getForm()`, `validateForm()`, `validateDelete()` |
| [admin/controller/member/partner.php:1](../../admin/controller/member/partner.php#L1) |  ControllerMemberPartner | `index()`, `add()`, `edit()`, `delete()`, `getList()`, `getForm()`, `validateForm()`, `validateDelete()` |
| [admin/controller/member/seller.php:1](../../admin/controller/member/seller.php#L1) |  ControllerMemberSeller | `index()`, `add()`, `edit()`, `delete()`, `getList()`, `getForm()`, `validateForm()`, `validateDelete()` |
| [admin/controller/sale/order.php:1](../../admin/controller/sale/order.php#L1) |  ControllerSaleOrder | `index()`, `add()`, `edit()`, `delete()`, `getList()`, `info()`, `getForm()`, `validateForm()`, `validateDelete()`, `getStatusClass()` |
| [admin/controller/setting/payment.php:1](../../admin/controller/setting/payment.php#L1) |  ControllerSettingPayment | `index()`, `testStripe()`, `testBraintree()`, `testPaypal()`, `validate()` |
| [admin/controller/setting/setting.php:1](../../admin/controller/setting/setting.php#L1) |  ControllerSettingSetting | `index()`, `validate()`, `testSmtp()`, `testStorage()` |
| [admin/controller/setting/store.php:1](../../admin/controller/setting/store.php#L1) |  ControllerSettingStore | `index()`, `add()`, `edit()`, `delete()`, `getList()`, `getForm()`, `validateForm()`, `validateDelete()` |
| [admin/controller/startup/error.php:1](../../admin/controller/startup/error.php#L1) |  ControllerStartupError | `index()`, `handler()` |
| [admin/controller/startup/event.php:1](../../admin/controller/startup/event.php#L1) |  ControllerStartupEvent | `index()` |
| [admin/controller/startup/login.php:1](../../admin/controller/startup/login.php#L1) |  ControllerStartupLogin | `index()` |
| [admin/controller/startup/permission.php:1](../../admin/controller/startup/permission.php#L1) |  ControllerStartupPermission | `index()` |
| [admin/controller/startup/router.php:1](../../admin/controller/startup/router.php#L1) |  ControllerStartupRouter | `index()` |
| [admin/controller/startup/sass.php:1](../../admin/controller/startup/sass.php#L1) |  ControllerStartupSass | `index()` |
| [admin/controller/startup/startup.php:1](../../admin/controller/startup/startup.php#L1) |  ControllerStartupStartup | `index()` |
| [admin/controller/support/enquiry.php:1](../../admin/controller/support/enquiry.php#L1) |  ControllerSupportEnquiry | `index()`, `info()`, `delete()`, `getFilterUrl()`, `getList()`, `validateDelete()` |
| [admin/controller/tool/backup.php:1](../../admin/controller/tool/backup.php#L1) |  ControllerToolBackup | `index()`, `import()`, `export()` |
| [admin/controller/tool/log.php:1](../../admin/controller/tool/log.php#L1) |  ControllerToolLog | `index()`, `download()`, `clear()` |
| [admin/controller/tool/upload.php:1](../../admin/controller/tool/upload.php#L1) |  ControllerToolUpload | `index()`, `delete()`, `getList()`, `validateDelete()`, `download()`, `upload()` |
| [admin/controller/user/api.php:1](../../admin/controller/user/api.php#L1) |  ControllerUserApi | `index()`, `add()`, `edit()`, `delete()`, `getList()`, `getForm()`, `validateForm()`, `validateDelete()`, `deleteSession()` |
| [admin/controller/user/user.php:1](../../admin/controller/user/user.php#L1) |  ControllerUserUser | `index()`, `add()`, `edit()`, `delete()`, `getList()`, `getForm()`, `validateForm()`, `validateDelete()` |
| [admin/controller/user/user_permission.php:1](../../admin/controller/user/user_permission.php#L1) |  ControllerUserUserPermission | `index()`, `add()`, `edit()`, `delete()`, `getList()`, `getForm()`, `validateForm()`, `validateDelete()` |
| [admin/index.php:1](../../admin/index.php#L1) |   |  |
| [admin/language/en-gb/cloud/subscription.php:1](../../admin/language/en-gb/cloud/subscription.php#L1) |   |  |
| [admin/language/en-gb/cms/blog.php:1](../../admin/language/en-gb/cms/blog.php#L1) |   |  |
| [admin/language/en-gb/cms/blog_category.php:1](../../admin/language/en-gb/cms/blog_category.php#L1) |   |  |
| [admin/language/en-gb/cms/blog_comment.php:1](../../admin/language/en-gb/cms/blog_comment.php#L1) |   |  |
| [admin/language/en-gb/cms/download.php:1](../../admin/language/en-gb/cms/download.php#L1) |   |  |
| [admin/language/en-gb/cms/information.php:1](../../admin/language/en-gb/cms/information.php#L1) |   |  |
| [admin/language/en-gb/cms/showcase.php:1](../../admin/language/en-gb/cms/showcase.php#L1) |   |  |
| [admin/language/en-gb/common/column_left.php:1](../../admin/language/en-gb/common/column_left.php#L1) |   |  |
| [admin/language/en-gb/common/dashboard.php:1](../../admin/language/en-gb/common/dashboard.php#L1) |   |  |
| [admin/language/en-gb/common/developer.php:1](../../admin/language/en-gb/common/developer.php#L1) |   |  |
| [admin/language/en-gb/common/filemanager.php:1](../../admin/language/en-gb/common/filemanager.php#L1) |   |  |
| [admin/language/en-gb/common/footer.php:1](../../admin/language/en-gb/common/footer.php#L1) |   |  |
| [admin/language/en-gb/common/forgotten.php:1](../../admin/language/en-gb/common/forgotten.php#L1) |   |  |
| [admin/language/en-gb/common/header.php:1](../../admin/language/en-gb/common/header.php#L1) |   |  |
| [admin/language/en-gb/common/login.php:1](../../admin/language/en-gb/common/login.php#L1) |   |  |
| [admin/language/en-gb/common/profile.php:1](../../admin/language/en-gb/common/profile.php#L1) |   |  |
| [admin/language/en-gb/common/reset.php:1](../../admin/language/en-gb/common/reset.php#L1) |   |  |
| [admin/language/en-gb/common/security.php:1](../../admin/language/en-gb/common/security.php#L1) |   |  |
| [admin/language/en-gb/design/banner.php:1](../../admin/language/en-gb/design/banner.php#L1) |   |  |
| [admin/language/en-gb/design/seo_url.php:1](../../admin/language/en-gb/design/seo_url.php#L1) |   |  |
| [admin/language/en-gb/en-gb.php:1](../../admin/language/en-gb/en-gb.php#L1) |   |  |
| [admin/language/en-gb/error/not_found.php:1](../../admin/language/en-gb/error/not_found.php#L1) |   |  |
| [admin/language/en-gb/error/permission.php:1](../../admin/language/en-gb/error/permission.php#L1) |   |  |
| [admin/language/en-gb/localisation/country.php:1](../../admin/language/en-gb/localisation/country.php#L1) |   |  |
| [admin/language/en-gb/localisation/currency.php:1](../../admin/language/en-gb/localisation/currency.php#L1) |   |  |
| [admin/language/en-gb/localisation/language.php:1](../../admin/language/en-gb/localisation/language.php#L1) |   |  |
| [admin/language/en-gb/localisation/order_status.php:1](../../admin/language/en-gb/localisation/order_status.php#L1) |   |  |
| [admin/language/en-gb/localisation/zone.php:1](../../admin/language/en-gb/localisation/zone.php#L1) |   |  |
| [admin/language/en-gb/mail/affiliate_approve.php:1](../../admin/language/en-gb/mail/affiliate_approve.php#L1) |   |  |
| [admin/language/en-gb/mail/affiliate_deny.php:1](../../admin/language/en-gb/mail/affiliate_deny.php#L1) |   |  |
| [admin/language/en-gb/mail/customer_approve.php:1](../../admin/language/en-gb/mail/customer_approve.php#L1) |   |  |
| [admin/language/en-gb/mail/customer_deny.php:1](../../admin/language/en-gb/mail/customer_deny.php#L1) |   |  |
| [admin/language/en-gb/mail/forgotten.php:1](../../admin/language/en-gb/mail/forgotten.php#L1) |   |  |
| [admin/language/en-gb/mail/return.php:1](../../admin/language/en-gb/mail/return.php#L1) |   |  |
| [admin/language/en-gb/mail/reward.php:1](../../admin/language/en-gb/mail/reward.php#L1) |   |  |
| [admin/language/en-gb/mail/transaction.php:1](../../admin/language/en-gb/mail/transaction.php#L1) |   |  |
| [admin/language/en-gb/mail/voucher.php:1](../../admin/language/en-gb/mail/voucher.php#L1) |   |  |
| [admin/language/en-gb/marketplace/category.php:1](../../admin/language/en-gb/marketplace/category.php#L1) |   |  |
| [admin/language/en-gb/marketplace/comment.php:1](../../admin/language/en-gb/marketplace/comment.php#L1) |   |  |
| [admin/language/en-gb/marketplace/extension.php:1](../../admin/language/en-gb/marketplace/extension.php#L1) |   |  |
| [admin/language/en-gb/marketplace/promotion.php:1](../../admin/language/en-gb/marketplace/promotion.php#L1) |   |  |
| [admin/language/en-gb/member/member.php:1](../../admin/language/en-gb/member/member.php#L1) |   |  |
| [admin/language/en-gb/member/partner.php:1](../../admin/language/en-gb/member/partner.php#L1) |   |  |
| [admin/language/en-gb/member/seller.php:1](../../admin/language/en-gb/member/seller.php#L1) |   |  |
| [admin/language/en-gb/sale/order.php:1](../../admin/language/en-gb/sale/order.php#L1) |   |  |
| [admin/language/en-gb/setting/payment.php:1](../../admin/language/en-gb/setting/payment.php#L1) |   |  |
| [admin/language/en-gb/setting/setting.php:1](../../admin/language/en-gb/setting/setting.php#L1) |   |  |
| [admin/language/en-gb/setting/store.php:1](../../admin/language/en-gb/setting/store.php#L1) |   |  |
| [admin/language/en-gb/support/enquiry.php:1](../../admin/language/en-gb/support/enquiry.php#L1) |   |  |
| [admin/language/en-gb/tool/backup.php:1](../../admin/language/en-gb/tool/backup.php#L1) |   |  |
| [admin/language/en-gb/tool/log.php:1](../../admin/language/en-gb/tool/log.php#L1) |   |  |
| [admin/language/en-gb/tool/upload.php:1](../../admin/language/en-gb/tool/upload.php#L1) |   |  |
| [admin/language/en-gb/user/api.php:1](../../admin/language/en-gb/user/api.php#L1) |   |  |
| [admin/language/en-gb/user/user.php:1](../../admin/language/en-gb/user/user.php#L1) |   |  |
| [admin/language/en-gb/user/user_group.php:1](../../admin/language/en-gb/user/user_group.php#L1) |   |  |
| [admin/model/cloud/subscription.php:1](../../admin/model/cloud/subscription.php#L1) |  ModelCloudSubscription | `addSubscription()`, `editSubscription()`, `deleteSubscription()`, `getSubscription()`, `getSubscriptions()`, `getTotalSubscriptions()`, `getSubscriptionPlans()`, `getSubscriptionStatuses()`, `getSubscriptionDomains()`, `getSubscriptionHistories()`, `getSubscriptionTransactions()` |
| [admin/model/cms/blog.php:1](../../admin/model/cms/blog.php#L1) |  ModelCmsBlog | `addBlog()`, `editBlog()`, `deleteBlog()`, `getBlog()`, `getBlogs()`, `getTotalBlogs()` |
| [admin/model/cms/blog_category.php:1](../../admin/model/cms/blog_category.php#L1) |  ModelCmsBlogCategory | `addBlogCategory()`, `editBlogCategory()`, `deleteBlogCategory()`, `getBlogCategory()`, `getBlogCategories()`, `getTotalBlogCategories()` |
| [admin/model/cms/blog_comment.php:1](../../admin/model/cms/blog_comment.php#L1) |  ModelCmsBlogComment | `editBlogComment()`, `approveBlogComment()`, `deleteBlogComment()`, `getBlogComment()`, `getBlogComments()`, `getTotalBlogComments()` |
| [admin/model/cms/download.php:1](../../admin/model/cms/download.php#L1) |  ModelCmsDownload | `syncReleaseLinks()`, `addDownload()`, `editDownload()`, `deleteDownload()`, `getDownload()`, `getDownloads()`, `getTotalDownloads()` |
| [admin/model/cms/information.php:1](../../admin/model/cms/information.php#L1) |  ModelCmsInformation | `addInformation()`, `editInformation()`, `deleteInformation()`, `getInformation()`, `getInformations()`, `getInformationDescriptions()`, `getTotalInformations()` |
| [admin/model/cms/showcase.php:1](../../admin/model/cms/showcase.php#L1) |  ModelCmsShowcase | `addShowcase()`, `editShowcase()`, `deleteShowcase()`, `getShowcase()`, `getShowcases()`, `getTotalShowcases()`, `getShowcaseCategories()` |
| [admin/model/design/banner.php:1](../../admin/model/design/banner.php#L1) |  ModelDesignBanner | `addBanner()`, `editBanner()`, `deleteBanner()`, `getBanner()`, `getBanners()`, `getBannerImages()`, `getTotalBanners()` |
| [admin/model/design/seo_url.php:1](../../admin/model/design/seo_url.php#L1) |  ModelDesignSeoUrl | `addSeoUrl()`, `editSeoUrl()`, `deleteSeoUrl()`, `getSeoUrl()`, `getSeoUrls()`, `getTotalSeoUrls()`, `getSeoUrlsByKeyword()`, `getSeoUrlsByQuery()`, `getSeoUrlsByQueryId()`, `getSeoUrlsByKeywordId()` |
| [admin/model/localisation/country.php:1](../../admin/model/localisation/country.php#L1) |  ModelLocalisationCountry | `addCountry()`, `editCountry()`, `deleteCountry()`, `getCountry()`, `getCountries()`, `getTotalCountries()` |
| [admin/model/localisation/currency.php:1](../../admin/model/localisation/currency.php#L1) |  ModelLocalisationCurrency | `addCurrency()`, `editCurrency()`, `deleteCurrency()`, `getCurrency()`, `getCurrencyByCode()`, `getCurrencies()`, `refresh()`, `getTotalCurrencies()` |
| [admin/model/localisation/language.php:1](../../admin/model/localisation/language.php#L1) |  ModelLocalisationLanguage | `addLanguage()`, `editLanguage()`, `deleteLanguage()`, `getLanguage()`, `getLanguages()`, `getLanguageByCode()`, `getTotalLanguages()` |
| [admin/model/localisation/order_status.php:1](../../admin/model/localisation/order_status.php#L1) |  ModelLocalisationOrderStatus | `addOrderStatus()`, `editOrderStatus()`, `deleteOrderStatus()`, `getOrderStatus()`, `getOrderStatuses()`, `getOrderStatusDescriptions()`, `getTotalOrderStatuses()` |
| [admin/model/localisation/zone.php:1](../../admin/model/localisation/zone.php#L1) |  ModelLocalisationZone | `addZone()`, `editZone()`, `deleteZone()`, `getZone()`, `getZones()`, `getZonesByCountryId()`, `getTotalZones()`, `getTotalZonesByCountryId()` |
| [admin/model/marketplace/category.php:1](../../admin/model/marketplace/category.php#L1) |  ModelMarketplaceCategory | `addCategory()`, `editCategory()`, `deleteCategory()`, `getCategory()`, `getCategories()`, `getTotalCategories()` |
| [admin/model/marketplace/comment.php:1](../../admin/model/marketplace/comment.php#L1) |  ModelMarketplaceComment | `editComment()`, `approveComment()`, `deleteComment()`, `getComment()`, `getComments()`, `getTotalComments()` |
| [admin/model/marketplace/extension.php:1](../../admin/model/marketplace/extension.php#L1) |  ModelMarketplaceExtension | `addExtension()`, `editExtension()`, `deleteExtension()`, `getExtension()`, `getExtensions()`, `getTotalExtensions()`, `getExtensionImages()`, `getExtensionDownloads()` |
| [admin/model/marketplace/promotion.php:1](../../admin/model/marketplace/promotion.php#L1) |  ModelMarketplacePromotion | `addPromotion()`, `editPromotion()`, `deletePromotion()`, `getPromotion()`, `getPromotions()`, `getTotalPromotions()` |
| [admin/model/member/member.php:1](../../admin/model/member/member.php#L1) |  ModelMemberMember | `addMember()`, `editMember()`, `deleteMember()`, `getMember()`, `getMembers()`, `getTotalMembers()`, `addTransaction()`, `getTransactions()`, `getTransactionTotal()` |
| [admin/model/member/partner.php:1](../../admin/model/member/partner.php#L1) |  ModelMemberPartner | `addPartner()`, `editPartner()`, `deletePartner()`, `getPartner()`, `getPartners()`, `getTotalPartners()`, `getPartnerTypes()`, `getPartnerStatuses()` |
| [admin/model/member/seller.php:1](../../admin/model/member/seller.php#L1) |  ModelMemberSeller | `addSeller()`, `editSeller()`, `deleteSeller()`, `getSeller()`, `getSellers()`, `getTotalSellers()` |
| [admin/model/sale/order.php:1](../../admin/model/sale/order.php#L1) |  ModelSaleOrder | `addOrder()`, `editOrder()`, `updateOrderStatus()`, `deleteOrder()`, `getOrder()`, `getOrders()`, `getTotalOrders()`, `getTotalOrdersByOrderStatusId()` |
| [admin/model/setting/event.php:1](../../admin/model/setting/event.php#L1) |  ModelSettingEvent | `addEvent()`, `deleteEvent()`, `deleteEventByCode()`, `enableEvent()`, `disableEvent()`, `uninstall()`, `getEvent()`, `getEventByCode()`, `getEvents()`, `getTotalEvents()` |
| [admin/model/setting/setting.php:1](../../admin/model/setting/setting.php#L1) |  ModelSettingSetting | `getSetting()`, `editSetting()`, `deleteSetting()`, `getSettingValue()`, `editSettingValue()` |
| [admin/model/setting/store.php:1](../../admin/model/setting/store.php#L1) |  ModelSettingStore | `addStore()`, `editStore()`, `deleteStore()`, `getStore()`, `getStores()`, `getTotalStores()`, `getTotalStoresByLayoutId()`, `getTotalStoresByLanguage()`, `getTotalStoresByCurrency()`, `getTotalStoresByCountryId()`, `getTotalStoresByZoneId()`, `getTotalStoresByCustomerGroupId()`, `getTotalStoresByInformationId()`, `getTotalStoresByOrderStatusId()` |
| [admin/model/support/enquiry.php:1](../../admin/model/support/enquiry.php#L1) |  ModelSupportEnquiry | `deleteEnquiry()`, `getEnquiry()`, `getEnquiries()`, `getTotalEnquiries()` |
| [admin/model/tool/backup.php:1](../../admin/model/tool/backup.php#L1) |  ModelToolBackup | `getTables()`, `backup()` |
| [admin/model/tool/image.php:1](../../admin/model/tool/image.php#L1) |  ModelToolImage | `resize()` |
| [admin/model/tool/upload.php:1](../../admin/model/tool/upload.php#L1) |  ModelToolUpload | `addUpload()`, `deleteUpload()`, `getUpload()`, `getUploadByCode()`, `getUploads()`, `getTotalUploads()` |
| [admin/model/user/api.php:1](../../admin/model/user/api.php#L1) |  ModelUserApi | `addApi()`, `editApi()`, `deleteApi()`, `getApi()`, `getApis()`, `getTotalApis()`, `addApiIp()`, `getApiIps()`, `addApiSession()`, `getApiSessions()`, `deleteApiSession()`, `deleteApiSessionBySessionId()` |
| [admin/model/user/user.php:1](../../admin/model/user/user.php#L1) |  ModelUserUser | `addUser()`, `editUser()`, `editPassword()`, `editCode()`, `deleteUser()`, `getUser()`, `getUserByUsername()`, `getUserByEmail()`, `getUserByCode()`, `getUsers()`, `getTotalUsers()`, `getTotalUsersByGroupId()`, `getTotalUsersByEmail()`, `addLoginAttempt()`, `getLoginAttempts()`, `deleteLoginAttempts()` |
| [admin/model/user/user_group.php:1](../../admin/model/user/user_group.php#L1) |  ModelUserUserGroup | `addUserGroup()`, `editUserGroup()`, `deleteUserGroup()`, `getUserGroup()`, `getUserGroups()`, `getTotalUserGroups()`, `addPermission()`, `removePermission()` |
| [application/controller/account/account.php:1](../../application/controller/account/account.php#L1) |  ControllerAccountAccount | `index()` |
| [application/controller/account/download.php:1](../../application/controller/account/download.php#L1) |  ControllerAccountDownload | `index()`, `info()`, `download()` |
| [application/controller/account/edit.php:1](../../application/controller/account/edit.php#L1) |  ControllerAccountEdit | `index()`, `validate()` |
| [application/controller/account/extension.php:1](../../application/controller/account/extension.php#L1) |  ControllerAccountExtension | `index()`, `add()`, `edit()`, `delete()`, `getForm()`, `validateForm()`, `upload()`, `comment()`, `getCommentList()`, `replyComment()`, `deleteComment()` |
| [application/controller/account/forgotten.php:1](../../application/controller/account/forgotten.php#L1) |  ControllerAccountForgotten | `index()`, `validate()` |
| [application/controller/account/login.php:1](../../application/controller/account/login.php#L1) |  ControllerAccountLogin | `index()`, `validate()` |
| [application/controller/account/logout.php:1](../../application/controller/account/logout.php#L1) |  ControllerAccountLogout | `index()` |
| [application/controller/account/menu.php:1](../../application/controller/account/menu.php#L1) |  ControllerAccountMenu | `index()` |
| [application/controller/account/order.php:1](../../application/controller/account/order.php#L1) |  ControllerAccountOrder | `index()`, `info()` |
| [application/controller/account/partner.php:1](../../application/controller/account/partner.php#L1) |  ControllerAccountPartner | `index()`, `add()`, `edit()`, `getPartnerByMember()`, `savePartnerData()`, `getForm()`, `validateForm()` |
| [application/controller/account/password.php:1](../../application/controller/account/password.php#L1) |  ControllerAccountPassword | `index()`, `validate()` |
| [application/controller/account/payment.php:1](../../application/controller/account/payment.php#L1) |  ControllerAccountPayment | `index()`, `stripe()`, `braintree()`, `card()`, `paypal()`, `add()`, `makedefault()`, `delete()` |
| [application/controller/account/pin.php:1](../../application/controller/account/pin.php#L1) |  ControllerAccountPin | `index()`, `validate()` |
| [application/controller/account/promotion.php:1](../../application/controller/account/promotion.php#L1) |  ControllerAccountPromotion | `index()`, `info()` |
| [application/controller/account/rating.php:1](../../application/controller/account/rating.php#L1) |  ControllerAccountRating | `index()`, `rate()`, `getMemberRatingInfo()`, `validate()` |
| [application/controller/account/register.php:1](../../application/controller/account/register.php#L1) |  ControllerAccountRegister | `index()`, `validate()` |
| [application/controller/account/reset.php:1](../../application/controller/account/reset.php#L1) |  ControllerAccountReset | `index()`, `validate()` |
| [application/controller/account/sale.php:1](../../application/controller/account/sale.php#L1) |  ControllerAccountSale | `index()`, `export()`, `getFilteredSales()`, `getFilteredTotalSales()` |
| [application/controller/account/security.php:1](../../application/controller/account/security.php#L1) |  ControllerAccountSecurity | `index()`, `reset()`, `confirm()` |
| [application/controller/account/seller.php:1](../../application/controller/account/seller.php#L1) |  ControllerAccountSeller | `index()`, `add()`, `edit()`, `getForm()`, `validate()` |
| [application/controller/account/showcase.php:1](../../application/controller/account/showcase.php#L1) |  ControllerAccountShowcase | `index()`, `add()`, `delete()`, `getList()`, `getForm()`, `validateForm()` |
| [application/controller/account/store.php:1](../../application/controller/account/store.php#L1) |  ControllerAccountStore | `index()`, `add()`, `info()`, `secret()`, `delete()`, `getStoreInfo()`, `validateForm()` |
| [application/controller/account/subscription.php:1](../../application/controller/account/subscription.php#L1) |  ControllerAccountSubscription | `index()`, `add()`, `info()`, `update()`, `cancelSubscription()`, `renewSubscription()`, `restartSubscription()`, `history()`, `backup()`, `getBackupList()`, `createBackup()`, `restoreBackup()`, `removeBackup()`, `databaseBackup()`, `getDatabaseBackupList()`, `createDatabaseBackup()`, `restoreDatabaseBackup()`, `removeDatabaseBackup()`, `renderBackupList()`, `domain()`, `addDomain()`, `editDomain()`, `domainSettings()`, `deleteDomain()`, `pointDomain()`, `unpointDomain()`, `invoice()`, `invoiceInfo()` |
| [application/controller/account/success.php:1](../../application/controller/account/success.php#L1) |  ControllerAccountSuccess | `index()` |
| [application/controller/account/transaction.php:1](../../application/controller/account/transaction.php#L1) |  ControllerAccountTransaction | `index()` |
| [application/controller/account/verify.php:1](../../application/controller/account/verify.php#L1) |  ControllerAccountVerify | `index()` |
| [application/controller/checkout/checkout.php:1](../../application/controller/checkout/checkout.php#L1) |  ControllerCheckoutCheckout | `index()`, `success()`, `failure()`, `terms()` |
| [application/controller/checkout/payment.php:1](../../application/controller/checkout/payment.php#L1) |  ControllerCheckoutPayment | `index()`, `card()`, `paypal()`, `prepare()`, `confirm()` |
| [application/controller/cloud/cloud.php:1](../../application/controller/cloud/cloud.php#L1) |  ControllerCloudCloud | `index()`, `terms()` |
| [application/controller/cloud/landing.php:1](../../application/controller/cloud/landing.php#L1) |  ControllerCloudLanding | `index()` |
| [application/controller/cloud/store.php:1](../../application/controller/cloud/store.php#L1) |  ControllerCloudStore | `index()` |
| [application/controller/cms/banner.php:1](../../application/controller/cms/banner.php#L1) |  ControllerCmsBanner | `index()` |
| [application/controller/cms/blog.php:1](../../application/controller/cms/blog.php#L1) |  ControllerCmsBlog | `index()`, `info()`, `comment()`, `reply()`, `addcomment()`, `addreply()`, `removecomment()`, `removereply()` |
| [application/controller/cms/cart2cart.php:1](../../application/controller/cms/cart2cart.php#L1) |  ControllerCmsCart2cart | `index()` |
| [application/controller/cms/company.php:1](../../application/controller/cms/company.php#L1) |  ControllerCmsCompany | `index()` |
| [application/controller/cms/demo.php:1](../../application/controller/cms/demo.php#L1) |  ControllerCmsDemo | `index()` |
| [application/controller/cms/download.php:1](../../application/controller/cms/download.php#L1) |  ControllerCmsDownload | `index()`, `history()`, `download()`, `file()`, `populateFeaturedItems()` |
| [application/controller/cms/feature.php:1](../../application/controller/cms/feature.php#L1) |  ControllerCmsFeature | `index()` |
| [application/controller/cms/gdpr.php:1](../../application/controller/cms/gdpr.php#L1) |  ControllerCmsGdpr | `index()` |
| [application/controller/cms/guide.php:1](../../application/controller/cms/guide.php#L1) |  ControllerCmsGuide | `index()` |
| [application/controller/cms/information.php:1](../../application/controller/cms/information.php#L1) |  ControllerCmsInformation | `index()`, `agree()` |
| [application/controller/cms/newsletter.php:1](../../application/controller/cms/newsletter.php#L1) |  ControllerCmsNewsletter | `index()`, `subscribe()`, `unsubscribe()` |
| [application/controller/cms/privacy.php:1](../../application/controller/cms/privacy.php#L1) |  ControllerCmsPrivacy | `index()` |
| [application/controller/cms/refund.php:1](../../application/controller/cms/refund.php#L1) |  ControllerCmsRefund | `index()` |
| [application/controller/cms/showcase.php:1](../../application/controller/cms/showcase.php#L1) |  ControllerCmsShowcase | `index()` |
| [application/controller/cms/sitemap.php:1](../../application/controller/cms/sitemap.php#L1) |  ControllerCmsSitemap | `index()`, `robots()` |
| [application/controller/cms/terms.php:1](../../application/controller/cms/terms.php#L1) |  ControllerCmsTerms | `index()` |
| [application/controller/common/captcha.php:1](../../application/controller/common/captcha.php#L1) |  ControllerCommonCaptcha | `index()`, `check()` |
| [application/controller/common/footer.php:1](../../application/controller/common/footer.php#L1) |  ControllerCommonFooter | `index()` |
| [application/controller/common/header.php:1](../../application/controller/common/header.php#L1) |  ControllerCommonHeader | `index()` |
| [application/controller/common/home.php:1](../../application/controller/common/home.php#L1) |  ControllerCommonHome | `index()` |
| [application/controller/common/image.php:1](../../application/controller/common/image.php#L1) |  ControllerCommonImage | `index()` |
| [application/controller/common/maintenance.php:1](../../application/controller/common/maintenance.php#L1) |  ControllerCommonMaintenance | `index()` |
| [application/controller/common/pagination.php:1](../../application/controller/common/pagination.php#L1) |  ControllerCommonPagination | `index()` |
| [application/controller/error/not_found.php:1](../../application/controller/error/not_found.php#L1) |  ControllerErrorNotFound | `index()` |
| [application/controller/event/language.php:1](../../application/controller/event/language.php#L1) |  ControllerEventLanguage | `index()`, `before()`, `after()` |
| [application/controller/event/translation.php:1](../../application/controller/event/translation.php#L1) |  ControllerEventTranslation | `index()` |
| [application/controller/localisation/country.php:1](../../application/controller/localisation/country.php#L1) |  ControllerLocalisationCountry | `index()` |
| [application/controller/mail/cloud_store.php:1](../../application/controller/mail/cloud_store.php#L1) |  ControllerMailCloudStore | `index()` |
| [application/controller/mail/comment.php:1](../../application/controller/mail/comment.php#L1) |  ControllerMailComment | `index()` |
| [application/controller/mail/extension.php:1](../../application/controller/mail/extension.php#L1) |  ControllerMailExtension | `index()` |
| [application/controller/mail/footer.php:1](../../application/controller/mail/footer.php#L1) |  ControllerMailFooter | `index()` |
| [application/controller/mail/forgotten.php:1](../../application/controller/mail/forgotten.php#L1) |  ControllerMailForgotten | `index()` |
| [application/controller/mail/header.php:1](../../application/controller/mail/header.php#L1) |  ControllerMailHeader | `index()` |
| [application/controller/mail/order.php:1](../../application/controller/mail/order.php#L1) |  ControllerMailOrder | `index()` |
| [application/controller/mail/payment.php:1](../../application/controller/mail/payment.php#L1) |  ControllerMailPayment | `index()` |
| [application/controller/mail/pin.php:1](../../application/controller/mail/pin.php#L1) |  ControllerMailPin | `index()` |
| [application/controller/mail/register.php:1](../../application/controller/mail/register.php#L1) |  ControllerMailRegister | `index()` |
| [application/controller/mail/seller.php:1](../../application/controller/mail/seller.php#L1) |  ControllerMailSeller | `index()` |
| [application/controller/mail/subscription.php:1](../../application/controller/mail/subscription.php#L1) |  ControllerMailSubscription | `index()` |
| [application/controller/marketplace/braintree.php:1](../../application/controller/marketplace/braintree.php#L1) |  ControllerMarketplaceBraintree | `index()`, `payment()`, `vaulted()`, `remove()` |
| [application/controller/marketplace/download.php:1](../../application/controller/marketplace/download.php#L1) |  ControllerMarketplaceDownload | `index()`, `download()` |
| [application/controller/marketplace/extension.php:1](../../application/controller/marketplace/extension.php#L1) |  ControllerMarketplaceExtension | `index()`, `info()`, `comment()`, `reply()`, `addcomment()`, `addreply()`, `removecomment()`, `removereply()` |
| [application/controller/marketplace/paypal.php:1](../../application/controller/marketplace/paypal.php#L1) |  ControllerMarketplacePaypal | `index()`, `send()`, `callback()` |
| [application/controller/marketplace/purchase.php:1](../../application/controller/marketplace/purchase.php#L1) |  ControllerMarketplacePurchase | `index()`, `terms()`, `success()`, `failure()` |
| [application/controller/startup/error.php:1](../../application/controller/startup/error.php#L1) |  ControllerStartupError | `index()`, `handler()` |
| [application/controller/startup/event.php:1](../../application/controller/startup/event.php#L1) |  ControllerStartupEvent | `index()` |
| [application/controller/startup/maintenance.php:1](../../application/controller/startup/maintenance.php#L1) |  ControllerStartupMaintenance | `index()` |
| [application/controller/startup/router.php:1](../../application/controller/startup/router.php#L1) |  ControllerStartupRouter | `index()` |
| [application/controller/startup/seo_url.php:1](../../application/controller/startup/seo_url.php#L1) |  ControllerStartupSeoUrl | `index()`, `rewrite()` |
| [application/controller/startup/session.php:1](../../application/controller/startup/session.php#L1) |  ControllerStartupSession | `index()` |
| [application/controller/startup/startup.php:1](../../application/controller/startup/startup.php#L1) |  ControllerStartupStartup | `index()` |
| [application/controller/support/advertise.php:1](../../application/controller/support/advertise.php#L1) |  ControllerSupportAdvertise | `index()`, `send()` |
| [application/controller/support/contact.php:1](../../application/controller/support/contact.php#L1) |  ControllerSupportContact | `index()`, `reason()`, `send()`, `success()` |
| [application/controller/support/partner.php:1](../../application/controller/support/partner.php#L1) |  ControllerSupportPartner | `index()`, `info()`, `contact()`, `send()`, `success()` |
| [application/controller/support/seller.php:1](../../application/controller/support/seller.php#L1) |  ControllerSupportSeller | `index()`, `send()`, `success()` |
| [application/controller/support/support.php:1](../../application/controller/support/support.php#L1) |  ControllerSupportSupport | `index()` |
| [application/controller/upgrade/upgrade.php:1](../../application/controller/upgrade/upgrade.php#L1) |  ControllerUpgradeUpgrade | `index()`, `next()` |
| [application/language/en-gb/en-gb.php:1](../../application/language/en-gb/en-gb.php#L1) |   |  |
| [application/model/account/extension.php:1](../../application/model/account/extension.php#L1) |  ModelAccountExtension |  |
| [application/model/account/member.php:1](../../application/model/account/member.php#L1) |  ModelAccountMember | `addMember()`, `editMember()`, `editPassword()`, `editCode()`, `editPin()`, `incrementPinAttempts()`, `resetPinAttempts()`, `resetMemberPin()`, `editNewsletter()`, `verifyMember()`, `getMember()`, `getMemberByEmail()`, `getMemberByUsername()`, `getMemberByLogin()`, `getMemberByCode()`, `getTotalMembersByEmail()`, `getTotalMembersByUsername()`, `addMemberIp()`, `isTrustedIp()`, `getIps()`, `getTotalIps()`, `addLoginAttempt()`, `getLoginAttempts()`, `deleteLoginAttempts()` |
| [application/model/account/order.php:1](../../application/model/account/order.php#L1) |  ModelAccountOrder | `addOrder()`, `editOrderStatus()`, `getOrder()`, `getOrders()`, `getTotalOrders()`, `getSale()`, `getSales()`, `getTotalSales()`, `hasPurchasedExtension()`, `getPurchasedExtensions()`, `getTotalPurchasedExtensions()` |
| [application/model/account/partner.php:1](../../application/model/account/partner.php#L1) |  ModelAccountPartner | `getPartner()`, `getPartnerByMemberId()`, `getPartners()`, `getTotalPartners()`, `getPartnerCountries()`, `getPartnerTypes()`, `getMemberPartnerTypes()`, `getPartnerStatuses()`, `getMemberPartnerStatuses()`, `addPartner()`, `editPartner()` |
| [application/model/account/payment.php:1](../../application/model/account/payment.php#L1) |  ModelAccountPayment | `addPayment()`, `editPayment()`, `setDefaultPayment()`, `deletePayment()`, `getPayment()`, `getDefaultPayment()`, `getPayments()`, `getTotalPayments()` |
| [application/model/account/promotion.php:1](../../application/model/account/promotion.php#L1) |  ModelAccountPromotion | `addPromotion()`, `deletePromotion()`, `getPromotion()`, `getPromotions()`, `getTotalPromotions()` |
| [application/model/account/seller.php:1](../../application/model/account/seller.php#L1) |  ModelAccountSeller | `addSeller()`, `editSeller()`, `getSeller()`, `getSellerByMemberId()` |
| [application/model/account/showcase.php:1](../../application/model/account/showcase.php#L1) |  ModelAccountShowcase |  |
| [application/model/account/store.php:1](../../application/model/account/store.php#L1) |  ModelAccountStore | `addStore()`, `editStore()`, `deleteStore()`, `getStore()`, `getStores()`, `getTotalStores()` |
| [application/model/account/subscription.php:1](../../application/model/account/subscription.php#L1) |  ModelAccountSubscription | `getSubscriptionPlan()`, `getSubscriptionPlans()`, `getSubscriptionStatus()`, `getSubscriptionStatuses()`, `addSubscription()`, `editSubscription()`, `editSubscriptionPlan()`, `editSubscriptionPayment()`, `cancelSubscription()`, `getSubscription()`, `getSubscriptions()`, `getTotalSubscriptions()`, `addSubscriptionDomain()`, `addDomain()`, `deleteSubscriptionDomain()`, `deleteDomain()`, `getSubscriptionDomain()`, `getDomain()`, `getSubscriptionDomains()`, `getDomains()`, `getTotalSubscriptionDomains()`, `getTotalDomains()`, `addSubscriptionHistory()`, `getSubscriptionHistories()`, `getTotalSubscriptionHistories()`, `addSubscriptionTransaction()`, `getSubscriptionTransaction()`, `getSubscriptionTransactions()`, `getTotalSubscriptionTransactions()`, `addSubscriptionBackup()`, `addBackup()`, `deleteSubscriptionBackup()`, `deleteBackup()`, `getSubscriptionBackup()`, `getBackup()`, `getSubscriptionBackups()`, `getBackups()`, `getTotalSubscriptionBackups()`, `getTotalBackups()` |
| [application/model/account/transaction.php:1](../../application/model/account/transaction.php#L1) |  ModelAccountTransaction | `addTransaction()`, `getTransactions()`, `getTotalTransactions()`, `getTransactionTotal()` |
| [application/model/cms/blog.php:1](../../application/model/cms/blog.php#L1) |  ModelCmsBlog | `getBlogCategory()`, `getBlogCategories()`, `getBlog()`, `getBlogs()`, `getTotalBlogs()`, `updateViewed()`, `addComment()`, `deleteComment()`, `getComment()`, `getCommentsByBlogId()`, `getComments()`, `getTotalCommentsByBlogId()`, `getTotalComments()`, `getRepliesByCommentId()`, `getReplies()`, `getTotalRepliesByCommentId()`, `getTotalReplies()` |
| [application/model/cms/download.php:1](../../application/model/cms/download.php#L1) |  ModelCmsDownload | `getReleaseUrl()`, `syncReleaseLinks()`, `normalizeRow()`, `getLatestDownload()`, `getDownload()`, `getDownloads()`, `getTotalDownloads()` |
| [application/model/cms/information.php:1](../../application/model/cms/information.php#L1) |  ModelCmsInformation | `getInformation()`, `getInformations()` |
| [application/model/cms/newsletter.php:1](../../application/model/cms/newsletter.php#L1) |  ModelCmsNewsletter | `addNewsletter()`, `deleteNewsletter()`, `getNewsletterByEmail()`, `getTotalNewslettersByEmail()` |
| [application/model/cms/showcase.php:1](../../application/model/cms/showcase.php#L1) |  ModelCmsShowcase | `getShowcaseCategory()`, `getShowcaseCategories()`, `getShowcase()`, `getShowcases()`, `getTotalShowcases()`, `addShowcase()`, `editShowcase()`, `deleteShowcase()` |
| [application/model/design/banner.php:1](../../application/model/design/banner.php#L1) |  ModelDesignBanner | `getBanner()` |
| [application/model/design/seo_url.php:1](../../application/model/design/seo_url.php#L1) |  ModelDesignSeoUrl | `getSeoUrlsByKeyword()`, `getSeoUrlsByQuery()` |
| [application/model/design/translation.php:1](../../application/model/design/translation.php#L1) |  ModelDesignTranslation | `getTranslations()` |
| [application/model/localisation/country.php:1](../../application/model/localisation/country.php#L1) |  ModelLocalisationCountry | `getCountry()`, `getCountries()` |
| [application/model/localisation/currency.php:1](../../application/model/localisation/currency.php#L1) |  ModelLocalisationCurrency | `getCurrencyByCode()`, `getCurrencies()` |
| [application/model/localisation/language.php:1](../../application/model/localisation/language.php#L1) |  ModelLocalisationLanguage | `getLanguage()`, `getLanguageByCode()`, `getLanguages()` |
| [application/model/localisation/order_status.php:1](../../application/model/localisation/order_status.php#L1) |  ModelLocalisationOrderStatus | `getOrderStatus()`, `getOrderStatuses()` |
| [application/model/localisation/zone.php:1](../../application/model/localisation/zone.php#L1) |  ModelLocalisationZone | `getZone()`, `getZonesByCountryId()` |
| [application/model/marketplace/extension.php:1](../../application/model/marketplace/extension.php#L1) |  ModelMarketplaceExtension | `getExtensionCategory()`, `getExtensionCategories()`, `getExtension()`, `getExtensions()`, `getTotalExtensions()`, `getPromotions()`, `getExtensionImages()`, `getExtensionDownload()`, `getExtensionDownloads()`, `getExtensionDownloadPaths()`, `getExtensionCompatibilities()`, `updateDownloaded()`, `addExtensionRating()`, `addRating()`, `updateExtensionRatingStats()`, `getExtensionRatings()`, `getRatings()`, `getReviewsByExtensionId()`, `getTotalExtensionRatings()`, `getTotalRatings()`, `getTotalReviewsByExtensionId()`, `getRatingByOrderId()`, `getMemberRating()`, `addComment()`, `deleteComment()`, `getComment()`, `getCommentsByExtensionId()`, `getComments()`, `getTotalCommentsByExtensionId()`, `getTotalComments()`, `getRepliesByCommentId()`, `getReplies()`, `getTotalRepliesByCommentId()`, `getTotalReplies()`, `addExtension()`, `editExtension()`, `deleteExtension()` |
| [application/model/setting/event.php:1](../../application/model/setting/event.php#L1) |  ModelSettingEvent | `getEvents()` |
| [application/model/setting/setting.php:1](../../application/model/setting/setting.php#L1) |  ModelSettingSetting | `getSetting()`, `getSettingValue()` |
| [application/model/support/enquiry.php:1](../../application/model/support/enquiry.php#L1) |  ModelSupportEnquiry | `addEnquiry()` |
| [application/model/tool/image.php:1](../../application/model/tool/image.php#L1) |  ModelToolImage | `resize()` |
| [application/model/tool/upload.php:1](../../application/model/tool/upload.php#L1) |  ModelToolUpload | `addUpload()`, `getUploadByCode()` |
| [config-dist.php:1](../../config-dist.php#L1) |   |  |
| [config.php:1](../../config.php#L1) |   |  |
| [index.php:1](../../index.php#L1) |   |  |
| [install/cli_install.php:1](../../install/cli_install.php#L1) |   | `handleError()`, `usage()`, `get_options()`, `valid()`, `install()`, `check_requirements()`, `setup_db()`, `write_config_files()`, `dir_permissions()` |
| [install/controller/3rd_party/extension.php:1](../../install/controller/3rd_party/extension.php#L1) |  Controller3rdPartyExtension | `index()` |
| [install/controller/common/column_left.php:1](../../install/controller/common/column_left.php#L1) |  ControllerCommonColumnLeft | `index()`, `language()` |
| [install/controller/common/footer.php:1](../../install/controller/common/footer.php#L1) |  ControllerCommonFooter | `index()` |
| [install/controller/common/header.php:1](../../install/controller/common/header.php#L1) |  ControllerCommonHeader | `index()` |
| [install/controller/error/not_found.php:1](../../install/controller/error/not_found.php#L1) |  ControllerErrorNotFound | `index()` |
| [install/controller/event/theme.php:1](../../install/controller/event/theme.php#L1) |  ControllerEventTheme | `index()` |
| [install/controller/install/promotion.php:1](../../install/controller/install/promotion.php#L1) |  ControllerInstallPromotion | `index()` |
| [install/controller/install/step_1.php:1](../../install/controller/install/step_1.php#L1) |  ControllerInstallStep1 | `index()` |
| [install/controller/install/step_2.php:1](../../install/controller/install/step_2.php#L1) |  ControllerInstallStep2 | `index()`, `validate()` |
| [install/controller/install/step_3.php:1](../../install/controller/install/step_3.php#L1) |  ControllerInstallStep3 | `index()`, `validate()` |
| [install/controller/install/step_4.php:1](../../install/controller/install/step_4.php#L1) |  ControllerInstallStep4 | `index()` |
| [install/controller/startup/database.php:1](../../install/controller/startup/database.php#L1) |  ControllerStartupDatabase | `index()` |
| [install/controller/startup/language.php:1](../../install/controller/startup/language.php#L1) |  ControllerStartupLanguage | `index()` |
| [install/controller/startup/router.php:1](../../install/controller/startup/router.php#L1) |  ControllerStartupRouter | `index()` |
| [install/controller/startup/upgrade.php:1](../../install/controller/startup/upgrade.php#L1) |  ControllerStartupUpgrade | `index()` |
| [install/controller/upgrade/upgrade.php:1](../../install/controller/upgrade/upgrade.php#L1) |  ControllerUpgradeUpgrade | `index()`, `next()` |
| [install/index.php:1](../../install/index.php#L1) |   |  |
| [install/language/en-gb/common/column_left.php:1](../../install/language/en-gb/common/column_left.php#L1) |   |  |
| [install/language/en-gb/common/footer.php:1](../../install/language/en-gb/common/footer.php#L1) |   |  |
| [install/language/en-gb/common/header.php:1](../../install/language/en-gb/common/header.php#L1) |   |  |
| [install/language/en-gb/en-gb.php:1](../../install/language/en-gb/en-gb.php#L1) |   |  |
| [install/language/en-gb/install/step_1.php:1](../../install/language/en-gb/install/step_1.php#L1) |  of |  |
| [install/language/en-gb/install/step_2.php:1](../../install/language/en-gb/install/step_2.php#L1) |   |  |
| [install/language/en-gb/install/step_3.php:1](../../install/language/en-gb/install/step_3.php#L1) |   |  |
| [install/language/en-gb/install/step_4.php:1](../../install/language/en-gb/install/step_4.php#L1) |   |  |
| [install/language/en-gb/upgrade/upgrade.php:1](../../install/language/en-gb/upgrade/upgrade.php#L1) |   |  |
| [install/model/install/install.php:1](../../install/model/install/install.php#L1) |  ModelInstallInstall | `database()` |
| [install/model/upgrade/1000.php:1](../../install/model/upgrade/1000.php#L1) |  ModelUpgrade1000 | `upgrade()` |
| [install/model/upgrade/1001.php:1](../../install/model/upgrade/1001.php#L1) |  ModelUpgrade1001 | `tableExists()`, `columnExists()`, `upgrade()` |
| [install/model/upgrade/1002.php:1](../../install/model/upgrade/1002.php#L1) |  ModelUpgrade1002 | `tableExists()`, `columnExists()`, `upgrade()`, `repairCategories()` |
| [install/model/upgrade/1003.php:1](../../install/model/upgrade/1003.php#L1) |  ModelUpgrade1003 | `tableExists()`, `columnExists()`, `upgrade()` |
| [install/model/upgrade/1004.php:1](../../install/model/upgrade/1004.php#L1) |  ModelUpgrade1004 | `tableExists()`, `columnExists()`, `upgrade()` |
| [install/model/upgrade/1005.php:1](../../install/model/upgrade/1005.php#L1) |  ModelUpgrade1005 | `tableExists()`, `columnExists()`, `upgrade()` |
| [install/model/upgrade/1006.php:1](../../install/model/upgrade/1006.php#L1) |  ModelUpgrade1006 | `tableExists()`, `columnExists()`, `upgrade()` |
| [install/model/upgrade/1007.php:1](../../install/model/upgrade/1007.php#L1) |  ModelUpgrade1007 | `tableExists()`, `columnExists()`, `upgrade()` |
| [install/model/upgrade/1008.php:1](../../install/model/upgrade/1008.php#L1) |  ModelUpgrade1008 | `tableExists()`, `columnExists()`, `upgrade()` |
| [install/model/upgrade/1009.php:1](../../install/model/upgrade/1009.php#L1) |  ModelUpgrade1009 | `tableExists()`, `columnExists()`, `upgrade()` |
| [system/config/admin.php:1](../../system/config/admin.php#L1) |   |  |
| [system/config/application.php:1](../../system/config/application.php#L1) |   |  |
| [system/config/default.php:1](../../system/config/default.php#L1) |   |  |
| [system/config/install.php:1](../../system/config/install.php#L1) |   |  |
| [system/engine/action.php:1](../../system/engine/action.php#L1) |  Action | `__construct()`, `getId()`, `execute()` |
| [system/engine/controller.php:1](../../system/engine/controller.php#L1) |  Controller | `__construct()`, `__get()`, `__set()` |
| [system/engine/event.php:1](../../system/engine/event.php#L1) |  Event | `__construct()`, `register()`, `trigger()`, `unregister()`, `clear()` |
| [system/engine/loader.php:1](../../system/engine/loader.php#L1) |  Loader | `__construct()`, `controller()`, `model()`, `view()`, `library()`, `helper()`, `config()`, `language()`, `callback()` |
| [system/engine/model.php:1](../../system/engine/model.php#L1) |  Model | `__construct()`, `__get()`, `__set()` |
| [system/engine/proxy.php:1](../../system/engine/proxy.php#L1) |  Proxy | `__get()`, `__set()`, `__call()` |
| [system/engine/registry.php:1](../../system/engine/registry.php#L1) |  Registry | `get()`, `set()`, `has()` |
| [system/engine/router.php:1](../../system/engine/router.php#L1) |  Router | `__construct()`, `addPreAction()`, `dispatch()`, `execute()` |
| [system/framework.php:1](../../system/framework.php#L1) |  as |  |
| [system/helper/bbcode.php:1](../../system/helper/bbcode.php#L1) |   | `bbcode_decode()` |
| [system/helper/general.php:1](../../system/helper/general.php#L1) |   | `token()`, `hash_equals()`, `time_ago()` |
| [system/helper/utf8.php:1](../../system/helper/utf8.php#L1) |   | `utf8_strlen()`, `utf8_strpos()`, `utf8_strrpos()`, `utf8_substr()`, `utf8_strtoupper()`, `utf8_strtolower()`, `utf8_strlen()`, `utf8_strpos()`, `utf8_strrpos()`, `utf8_substr()`, `utf8_strtolower()`, `utf8_strtoupper()`, `utf8_to_unicode()`, `unicode_to_utf8()` |
| [system/library/cache.php:1](../../system/library/cache.php#L1) |  Cache | `__construct()`, `get()`, `set()`, `delete()` |
| [system/library/cache/apc.php:1](../../system/library/cache/apc.php#L1) | Cache APC | `__construct()`, `get()`, `set()`, `delete()` |
| [system/library/cache/file.php:1](../../system/library/cache/file.php#L1) | Cache File | `__construct()`, `get()`, `set()`, `delete()` |
| [system/library/cache/mem.php:1](../../system/library/cache/mem.php#L1) | Cache Mem | `__construct()`, `get()`, `set()`, `delete()` |
| [system/library/cache/memcached.php:1](../../system/library/cache/memcached.php#L1) | Cache Memcached | `__construct()`, `get()`, `set()`, `delete()` |
| [system/library/cache/redis.php:1](../../system/library/cache/redis.php#L1) | Cache Redis | `__construct()`, `get()`, `set()`, `delete()` |
| [system/library/cart/currency.php:1](../../system/library/cart/currency.php#L1) | Cart Currency | `__construct()`, `format()`, `convert()`, `getId()`, `getSymbolLeft()`, `getSymbolRight()`, `getDecimalPlace()`, `getValue()`, `has()` |
| [system/library/cart/member.php:1](../../system/library/cart/member.php#L1) | Cart Member | `__construct()`, `getCurrentIp()`, `setFromRow()`, `login()`, `logout()`, `isLogged()`, `isVerified()`, `hasPin()`, `getPin()`, `getPinAttempts()`, `isIpVerified()`, `trustCurrentIp()`, `getId()`, `getUsername()`, `getFirstName()`, `getLastName()`, `getCompany()`, `getTaxId()`, `getEmail()`, `getTelephone()`, `getImage()`, `getCountryId()`, `getNotify()`, `isSeller()`, `isPartner()`, `isModerator()`, `hasCloud()`, `getDateAdded()`, `getBalance()` |
| [system/library/cart/user.php:1](../../system/library/cart/user.php#L1) | Cart User | `__construct()`, `login()`, `logout()`, `hasPermission()`, `isLogged()`, `getId()`, `getUserName()`, `getGroupId()` |
| [system/library/cloud_storage.php:1](../../system/library/cloud_storage.php#L1) |  CloudStorage | `__construct()`, `getSetting()`, `getDriver()`, `getLastError()`, `isEnabled()`, `isNativeGcsServiceAccount()`, `buildObjectKey()`, `getEndpointInfo()`, `storeUploadedFile()`, `fileExists()`, `outputFile()`, `putObject()`, `putObjectContent()`, `getObject()`, `deleteObject()`, `getPresignedUrl()`, `getPublicObjectUrl()`, `testConnection()`, `s3Request()`, `getGcsAccessToken()`, `gcsNativePutObject()`, `gcsNativeGetObject()`, `gcsNativeDeleteObject()`, `getSignatureKey()`, `uriEncodePath()`, `base64UrlEncode()`, `extractXmlError()`, `detectMimeType()` |
| [system/library/config.php:1](../../system/library/config.php#L1) |  Config | `get()`, `set()`, `has()`, `load()` |
| [system/library/db.php:1](../../system/library/db.php#L1) |  DB | `__construct()`, `query()`, `escape()`, `countAffected()`, `getLastId()`, `connected()` |
| [system/library/db/mysqli.php:1](../../system/library/db/mysqli.php#L1) | DB MySQLi | `__construct()`, `query()`, `escape()`, `countAffected()`, `getLastId()`, `isConnected()`, `__destruct()` |
| [system/library/db/pdo.php:1](../../system/library/db/pdo.php#L1) | DB PDO | `__construct()`, `prepare()`, `bindParam()`, `execute()`, `query()`, `escape()`, `countAffected()`, `getLastId()`, `isConnected()`, `__destruct()` |
| [system/library/db/pgsql.php:1](../../system/library/db/pgsql.php#L1) | DB PgSQL | `__construct()`, `query()`, `escape()`, `countAffected()`, `getLastId()`, `__destruct()` |
| [system/library/document.php:1](../../system/library/document.php#L1) |  Document | `setTitle()`, `getTitle()`, `setDescription()`, `getDescription()`, `setKeywords()`, `getKeywords()`, `addLink()`, `getLinks()`, `addStyle()`, `getStyles()`, `addScript()`, `getScripts()` |
| [system/library/encryption.php:1](../../system/library/encryption.php#L1) |  Encryption | `encrypt()`, `decrypt()` |
| [system/library/image.php:1](../../system/library/image.php#L1) |  Image | `__construct()`, `getFile()`, `getImage()`, `getWidth()`, `getHeight()`, `getBits()`, `getMime()`, `save()`, `resize()`, `watermark()`, `crop()`, `rotate()`, `filter()`, `text()`, `merge()`, `html2rgb()` |
| [system/library/language.php:1](../../system/library/language.php#L1) |  Language | `__construct()`, `get()`, `set()`, `all()`, `load()` |
| [system/library/log.php:1](../../system/library/log.php#L1) |  Log | `__construct()`, `write()`, `__destruct()` |
| [system/library/mail.php:1](../../system/library/mail.php#L1) |  Mail | `__construct()`, `setTo()`, `setFrom()`, `setSender()`, `setReplyTo()`, `setSubject()`, `setText()`, `setHtml()`, `addAttachment()`, `send()`, `testConnection()`, `logMail()` |
| [system/library/mail/mail.php:1](../../system/library/mail/mail.php#L1) | Mail Mail | `send()` |
| [system/library/mail/smtp.php:1](../../system/library/mail/smtp.php#L1) | Mail Smtp | `parseHostAndTls()`, `getServerName()`, `testConnection()`, `send()`, `handleReply()` |
| [system/library/pagination.php:1](../../system/library/pagination.php#L1) |  Pagination | `render()` |
| [system/library/payment_gateway.php:1](../../system/library/payment_gateway.php#L1) |  PaymentGateway | `__construct()`, `getActiveCardGateway()`, `isStripeEnabled()`, `isBraintreeEnabled()`, `isPayPalEnabled()`, `getStripeConfig()`, `getBraintreeConfig()`, `getPayPalConfig()`, `getFrontendConfig()`, `getClientToken()`, `getBrandLogo()`, `formatBrandName()`, `stripeRequest()`, `testStripeConnection()`, `getOrCreateStripeCustomer()`, `vaultStripeCard()`, `chargeStripe()`, `braintreeGraphQL()`, `testBraintreeConnection()`, `generateBraintreeClientToken()`, `vaultBraintreeCard()`, `chargeBraintree()`, `getPayPalAccessToken()` |
| [system/library/request.php:1](../../system/library/request.php#L1) |  Request | `__construct()`, `clean()` |
| [system/library/response.php:1](../../system/library/response.php#L1) |  Response | `addHeader()`, `redirect()`, `setCompression()`, `getOutput()`, `setOutput()`, `getImageDimensions()`, `getInlinedCoreCss()`, `optimizeCoreWebVitals()`, `compress()`, `output()` |
| [system/library/session.php:1](../../system/library/session.php#L1) |  Session | `__construct()`, `getId()`, `start()`, `close()`, `destroy()` |
| [system/library/session/db.php:1](../../system/library/session/db.php#L1) | Session DB | `__construct()`, `read()`, `write()`, `destroy()`, `gc()` |
| [system/library/session/file.php:1](../../system/library/session/file.php#L1) | Session File | `read()`, `write()`, `destroy()`, `__destruct()` |
| [system/library/template.php:1](../../system/library/template.php#L1) |  Template | `__construct()`, `set()`, `render()` |
| [system/library/template/template.php:1](../../system/library/template/template.php#L1) | Template Template | `set()`, `render()` |
| [system/library/template/twig.php:1](../../system/library/template/twig.php#L1) | Template Twig | `set()`, `render()` |
| [system/library/url.php:1](../../system/library/url.php#L1) |  Url | `__construct()`, `setToken()`, `addRewrite()`, `link()` |
| [system/startup.php:1](../../system/startup.php#L1) |   | `modification()`, `library()`, `start()` |
| [system/storage/cache/template/01/015b2ac381d206a10ea68ca07c08d76ddfa0d50add900a03b0e873a7582dfa81.php:1](../../system/storage/cache/template/01/015b2ac381d206a10ea68ca07c08d76ddfa0d50add900a03b0e873a7582dfa81.php#L1) |  __TwigTemplate_a61d9302f283ae7efddbd95a477137eaef44e4afce402540f8df29ad6adfca5b | `__construct()`, `doDisplay()`, `getTemplateName()`, `isTraitable()`, `getDebugInfo()`, `getSourceContext()` |
| [system/storage/cache/template/0a/0a3066b4e6e7593538835c49538fc0ad71bdb62e33757a52e22d7c1ca1fa0849.php:1](../../system/storage/cache/template/0a/0a3066b4e6e7593538835c49538fc0ad71bdb62e33757a52e22d7c1ca1fa0849.php#L1) |  __TwigTemplate_02d255900a45d4a3f6cf48c53956f010f08f26051d0e088fca9d90c0f1f9a850 | `__construct()`, `doDisplay()`, `getTemplateName()`, `isTraitable()`, `getDebugInfo()`, `getSourceContext()` |
| [system/storage/cache/template/0b/0b579a7fdc874e81bcf0225bbc1e2ce834d393038bd5810a82b7a9e533d9a077.php:1](../../system/storage/cache/template/0b/0b579a7fdc874e81bcf0225bbc1e2ce834d393038bd5810a82b7a9e533d9a077.php#L1) |  __TwigTemplate_fe5d2cd44772653d59da28a673dbb786b6571022062efdf8ebb34222b0b6311a | `__construct()`, `doDisplay()`, `getTemplateName()`, `isTraitable()`, `getDebugInfo()`, `getSourceContext()` |
| [system/storage/cache/template/0f/0ffcc154965690fc5748e0d07bd46bdc08812c55217967ff73600754760a93ed.php:1](../../system/storage/cache/template/0f/0ffcc154965690fc5748e0d07bd46bdc08812c55217967ff73600754760a93ed.php#L1) |  __TwigTemplate_aac39f203d65db9945682fd1778ea396bfef601c7b2c049ecb450a882e609f6a | `__construct()`, `doDisplay()`, `getTemplateName()`, `isTraitable()`, `getDebugInfo()`, `getSourceContext()` |
| [system/storage/cache/template/12/122f7fd83d76ad10e981aa1f8c6df41e187b2564b0deae10360b7564daebb80b.php:1](../../system/storage/cache/template/12/122f7fd83d76ad10e981aa1f8c6df41e187b2564b0deae10360b7564daebb80b.php#L1) |  __TwigTemplate_333185036aeabc6fe6af6009338c967f2a97288543b04daf20625f1d9742e225 | `__construct()`, `doDisplay()`, `getTemplateName()`, `getDebugInfo()`, `getSourceContext()` |
| [system/storage/cache/template/12/1292051e309a44251a756f5cc77ad7380cc23a9601c115fe53dcd5c533b433fe.php:1](../../system/storage/cache/template/12/1292051e309a44251a756f5cc77ad7380cc23a9601c115fe53dcd5c533b433fe.php#L1) |  __TwigTemplate_2b0a76bc619d33150fd4dccf4bc467421454b11f168669391be1e29500c2974f | `__construct()`, `doDisplay()`, `getTemplateName()`, `isTraitable()`, `getDebugInfo()`, `getSourceContext()` |
| [system/storage/cache/template/1a/1a851722ddeaa1c4b5541c5c942d5fa8b18aef4db5f562f03a195db5aff06951.php:1](../../system/storage/cache/template/1a/1a851722ddeaa1c4b5541c5c942d5fa8b18aef4db5f562f03a195db5aff06951.php#L1) |  __TwigTemplate_61541372de032efb15dd07f5dc07fca5dcbd932bf6f8d4324795223c7afbbe53 | `__construct()`, `doDisplay()`, `initMap()`, `getTemplateName()`, `isTraitable()`, `getDebugInfo()`, `getSourceContext()` |
| [system/storage/cache/template/1b/1b437de2a5622b1962f318f9c28149f9066f549dff1218629d0e6b29b2e8b31b.php:1](../../system/storage/cache/template/1b/1b437de2a5622b1962f318f9c28149f9066f549dff1218629d0e6b29b2e8b31b.php#L1) |  __TwigTemplate_0ef2e149c0958ba12304193171c238ccf8e40688eb2d2ad31cc803cc61259f71 | `__construct()`, `doDisplay()`, `getTemplateName()`, `isTraitable()`, `getDebugInfo()`, `getSourceContext()` |
| [system/storage/cache/template/1c/1cdc8938b4f62371222963adf9967734618f3ab8a87de4ff3f4fa66bb9a7e603.php:1](../../system/storage/cache/template/1c/1cdc8938b4f62371222963adf9967734618f3ab8a87de4ff3f4fa66bb9a7e603.php#L1) |  __TwigTemplate_ddb91112522a900e796004b0c086ab253a080d7fa334e78945477b0ff450bd4b | `__construct()`, `doDisplay()`, `getTemplateName()`, `isTraitable()`, `getDebugInfo()`, `getSourceContext()` |
| [system/storage/cache/template/23/23c97f86b14beb85d051ae3ff35c2f13f296a1bd8bafdd9e8eaee64d0d7c195f.php:1](../../system/storage/cache/template/23/23c97f86b14beb85d051ae3ff35c2f13f296a1bd8bafdd9e8eaee64d0d7c195f.php#L1) |  __TwigTemplate_c9f6e53ed8f658e585d84687fbd06854fd73e8efb671a89d2b229d02aea8c5e9 | `__construct()`, `doDisplay()`, `getTemplateName()`, `isTraitable()`, `getDebugInfo()`, `getSourceContext()` |
| [system/storage/cache/template/25/255537ee9fabc266f246792148b59fc4be7a681b6e35a4e5f2069267ff47f91a.php:1](../../system/storage/cache/template/25/255537ee9fabc266f246792148b59fc4be7a681b6e35a4e5f2069267ff47f91a.php#L1) |  __TwigTemplate_5a25837c34eee1b122aa3b278500cb153cc77c48d011991171998fa80977e938 | `__construct()`, `doDisplay()`, `getTemplateName()`, `isTraitable()`, `getDebugInfo()`, `getSourceContext()` |
| [system/storage/cache/template/29/29257723c9f7e35a5917aba585ac84146996873f69443b670cd28ef4198b7f4a.php:1](../../system/storage/cache/template/29/29257723c9f7e35a5917aba585ac84146996873f69443b670cd28ef4198b7f4a.php#L1) |  __TwigTemplate_362c387c19e107f7ee5c3e347f8444d4bf1be2d2daa062c8fb722872fc2414f9 | `__construct()`, `doDisplay()`, `getTemplateName()`, `isTraitable()`, `getDebugInfo()`, `getSourceContext()` |
| [system/storage/cache/template/2c/2c7b4fb1ced253a2f45fcd48ffcf1cc0468d01499403f010a0e5ac09447c9601.php:1](../../system/storage/cache/template/2c/2c7b4fb1ced253a2f45fcd48ffcf1cc0468d01499403f010a0e5ac09447c9601.php#L1) |  __TwigTemplate_a5510c161619dfefed26c6df9c0c3a93ed04561be0c7f0ac2fa67b8454f075f6 | `__construct()`, `doDisplay()`, `getTemplateName()`, `isTraitable()`, `getDebugInfo()`, `getSourceContext()` |
| [system/storage/cache/template/2f/2fb71a173831a6b9d7af2592017d3cb400c5a79c9efdbc05493c1d60c93bc19e.php:1](../../system/storage/cache/template/2f/2fb71a173831a6b9d7af2592017d3cb400c5a79c9efdbc05493c1d60c93bc19e.php#L1) |  __TwigTemplate_563148af86aa95a6f3c41d952222143f498b55dca78a0ea6f47fabbdba53b1b8 | `__construct()`, `doDisplay()`, `getTemplateName()`, `isTraitable()`, `getDebugInfo()`, `getSourceContext()` |
| [system/storage/cache/template/2f/2fdef9e058bebd0f141885448fbc63b35fbfc18b6d70a686b5d8b23f660f5061.php:1](../../system/storage/cache/template/2f/2fdef9e058bebd0f141885448fbc63b35fbfc18b6d70a686b5d8b23f660f5061.php#L1) |  __TwigTemplate_ded3193c85d41eb11acd20cd4aba25f8fe37827659c997f3acdf9ef1e9a7e813 | `__construct()`, `doDisplay()`, `getTemplateName()`, `isTraitable()`, `getDebugInfo()`, `getSourceContext()` |
| [system/storage/cache/template/30/30afc274b0a737eed5fa90a4fceb5b6d0df0061fe50c57d69c1f1e0988bfbf65.php:1](../../system/storage/cache/template/30/30afc274b0a737eed5fa90a4fceb5b6d0df0061fe50c57d69c1f1e0988bfbf65.php#L1) |  __TwigTemplate_eec32d39a4b7aad284e20da21cd2c14f536410fe0bf5fc6549e704407448573f | `__construct()`, `doDisplay()`, `getTemplateName()`, `isTraitable()`, `getDebugInfo()`, `getSourceContext()` |
| [system/storage/cache/template/35/354a757264861bc7c7c56ecce31585af3368e97aab0418b406547a5958f0a61b.php:1](../../system/storage/cache/template/35/354a757264861bc7c7c56ecce31585af3368e97aab0418b406547a5958f0a61b.php#L1) |  __TwigTemplate_b0432f514ac1fbc08d41e42fb9d4bb83ef93c0835733f6f1e5650c7950ece9f2 | `__construct()`, `doDisplay()`, `getTemplateName()`, `isTraitable()`, `getDebugInfo()`, `getSourceContext()` |
| [system/storage/cache/template/46/465e5d836c07f7816ea8aa3ba7412d6e24d0a643eca504e2cf5426ca34028aa2.php:1](../../system/storage/cache/template/46/465e5d836c07f7816ea8aa3ba7412d6e24d0a643eca504e2cf5426ca34028aa2.php#L1) |  __TwigTemplate_5bf00f37ae144aedc01043db43749dcec4b45f9646a69fbf348e02d1c732d73a | `__construct()`, `doDisplay()`, `getTemplateName()`, `isTraitable()`, `getDebugInfo()`, `getSourceContext()` |
| [system/storage/cache/template/49/49e1265622b172d5f5d48e3fc8581874eed6120df7444f9e907c4e4b42c0768d.php:1](../../system/storage/cache/template/49/49e1265622b172d5f5d48e3fc8581874eed6120df7444f9e907c4e4b42c0768d.php#L1) |  __TwigTemplate_c2524c381d80faac82998b1688080b685eb20743346e056f88146b24578ed18b | `__construct()`, `doDisplay()`, `getTemplateName()`, `isTraitable()`, `getDebugInfo()`, `getSourceContext()` |
| [system/storage/cache/template/4b/4b7a7fb826142a29e851b5ffae6ef1c45cc718ea94ad3503f5d4fc6383c98e7e.php:1](../../system/storage/cache/template/4b/4b7a7fb826142a29e851b5ffae6ef1c45cc718ea94ad3503f5d4fc6383c98e7e.php#L1) |  __TwigTemplate_52c77119df70352a2ad6358a711304455ae9f8f3ae740701fc5e56c48a241159 | `__construct()`, `doDisplay()`, `getTemplateName()`, `isTraitable()`, `getDebugInfo()`, `getSourceContext()` |
| [system/storage/cache/template/4d/4da1670f825542b85f4992110be807b352d773845ab59310d972b48b7602e54d.php:1](../../system/storage/cache/template/4d/4da1670f825542b85f4992110be807b352d773845ab59310d972b48b7602e54d.php#L1) |  __TwigTemplate_04df7f76e4b4ad283e82b7bbe21547fa39b339cf5bace68983be84e34b77827d | `__construct()`, `doDisplay()`, `getTemplateName()`, `isTraitable()`, `getDebugInfo()`, `getSourceContext()` |
| [system/storage/cache/template/56/5689b14c73b5e1ce88110e412207ef6440a905b9964a3e99cc3657c822be553c.php:1](../../system/storage/cache/template/56/5689b14c73b5e1ce88110e412207ef6440a905b9964a3e99cc3657c822be553c.php#L1) |  __TwigTemplate_692c4597fd85833b890b7931ea6613f12e6afee1adc773d0f4648db19ec88605 | `__construct()`, `doDisplay()`, `getTemplateName()`, `isTraitable()`, `getDebugInfo()`, `getSourceContext()` |
| [system/storage/cache/template/59/599076a747c4189ae87adba5f8b9fc7c303d45445d56a80574c37f06928b0e1c.php:1](../../system/storage/cache/template/59/599076a747c4189ae87adba5f8b9fc7c303d45445d56a80574c37f06928b0e1c.php#L1) |  __TwigTemplate_e03da9cefda6269f4165bc84fcd7eef2fbfa04260ad288eedcabe1086c0d7138 | `__construct()`, `doDisplay()`, `getTemplateName()`, `isTraitable()`, `getDebugInfo()`, `getSourceContext()` |
| [system/storage/cache/template/5d/5dad6f5bace1988199ee4540c22e49f16897d0cf87ddfe1dfbd6623d6aaa03ef.php:1](../../system/storage/cache/template/5d/5dad6f5bace1988199ee4540c22e49f16897d0cf87ddfe1dfbd6623d6aaa03ef.php#L1) |  __TwigTemplate_24c9a16a1d1c91b27c76692f2b491cafd19e76598edb6db13af452dc815faf00 | `__construct()`, `doDisplay()`, `getTemplateName()`, `isTraitable()`, `getDebugInfo()`, `getSourceContext()` |
| [system/storage/cache/template/5d/5dde56cf7d45c9c028a6c75d560cb5a00c276f49bdde4a416ea71daa488a7355.php:1](../../system/storage/cache/template/5d/5dde56cf7d45c9c028a6c75d560cb5a00c276f49bdde4a416ea71daa488a7355.php#L1) |  __TwigTemplate_e2f9cf89e3ad9e90dcfb6f61099e84730148762b3d1f4df5ac251b096ebc9846 | `__construct()`, `doDisplay()`, `getTemplateName()`, `isTraitable()`, `getDebugInfo()`, `getSourceContext()` |
| [system/storage/cache/template/5e/5e5b6e51aff97ed233e5eb829a2c8d099fcbcf6132a3a7dd92ff70c8acfddef7.php:1](../../system/storage/cache/template/5e/5e5b6e51aff97ed233e5eb829a2c8d099fcbcf6132a3a7dd92ff70c8acfddef7.php#L1) |  __TwigTemplate_52f67718f87576f737a50df5ef9a03e9706fa1732ea0018a855a9defcf013a93 | `__construct()`, `doDisplay()`, `getTemplateName()`, `isTraitable()`, `getDebugInfo()`, `getSourceContext()` |
| [system/storage/cache/template/5f/5fe3b0b3a3ccc845aee6a925a24a8cceb73c70f8b58b6770adc43553f367ea87.php:1](../../system/storage/cache/template/5f/5fe3b0b3a3ccc845aee6a925a24a8cceb73c70f8b58b6770adc43553f367ea87.php#L1) |  __TwigTemplate_0aa85457e085a6a6eedcc351c178363187d7193067997f3abf4fbd44200694f4 | `__construct()`, `doDisplay()`, `getTemplateName()`, `isTraitable()`, `getDebugInfo()`, `getSourceContext()` |
| [system/storage/cache/template/61/61aacd5617a4b11abcf320df44121bfd949fc6a8827aa67d5aa948e38ebf551f.php:1](../../system/storage/cache/template/61/61aacd5617a4b11abcf320df44121bfd949fc6a8827aa67d5aa948e38ebf551f.php#L1) |  __TwigTemplate_c94da96cbdac9df98d27afac9b28cceaca0d54763ce68d3044c2add3178c22db | `__construct()`, `doDisplay()`, `getTemplateName()`, `isTraitable()`, `getDebugInfo()`, `getSourceContext()` |
| [system/storage/cache/template/63/634e137ab30e47e4aa5822446df2053352a72ef03b47a7352dcfb0de46a8b002.php:1](../../system/storage/cache/template/63/634e137ab30e47e4aa5822446df2053352a72ef03b47a7352dcfb0de46a8b002.php#L1) |  __TwigTemplate_26da7c03747dc4e57d7f9369ac57c4541367dd28bf9614a99249b438418e6ebd | `__construct()`, `doDisplay()`, `getTemplateName()`, `isTraitable()`, `getDebugInfo()`, `getSourceContext()` |
| [system/storage/cache/template/66/661c5318d5ab5384a416c1d9d77897d8039e9039a2d544f534b54dcdde0f2eca.php:1](../../system/storage/cache/template/66/661c5318d5ab5384a416c1d9d77897d8039e9039a2d544f534b54dcdde0f2eca.php#L1) |  __TwigTemplate_146d5fed0928cbcf716d19bedb68681dcb2ea32fc186ce4153f25bb63508be2e | `__construct()`, `doDisplay()`, `getTemplateName()`, `isTraitable()`, `getDebugInfo()`, `getSourceContext()` |
| [system/storage/cache/template/6a/6af869bde586f0fe47470110d760e473d020a55b049287614fbbc8549bdff0b0.php:1](../../system/storage/cache/template/6a/6af869bde586f0fe47470110d760e473d020a55b049287614fbbc8549bdff0b0.php#L1) |  __TwigTemplate_43e7acf0de0441d478afc3bf3a8b638101b39397872c0422655c4d10059e4dc1 | `__construct()`, `doDisplay()`, `getTemplateName()`, `isTraitable()`, `getDebugInfo()`, `getSourceContext()` |
| [system/storage/cache/template/73/73d43c4a11f939c742f003f7924b124e63bee5f4340f92cd4a7b8c0d9856612e.php:1](../../system/storage/cache/template/73/73d43c4a11f939c742f003f7924b124e63bee5f4340f92cd4a7b8c0d9856612e.php#L1) |  __TwigTemplate_90eac7faadcbaecdd91a440bf0a6e0fe833ebe0b1cce189e5e640df99f5726e7 | `__construct()`, `doDisplay()`, `getTemplateName()`, `isTraitable()`, `getDebugInfo()`, `getSourceContext()` |
| [system/storage/cache/template/7f/7f2536d332ccfafd3589f64dc45cd248cf407f30e1eb209ab42f6472686b75f4.php:1](../../system/storage/cache/template/7f/7f2536d332ccfafd3589f64dc45cd248cf407f30e1eb209ab42f6472686b75f4.php#L1) |  __TwigTemplate_8cfac2351517256fd34ad47dca42ea1fbbc4963c7ad0e31d36ec9e33ad5c279d | `__construct()`, `doDisplay()`, `getTemplateName()`, `isTraitable()`, `getDebugInfo()`, `getSourceContext()` |
| [system/storage/cache/template/85/85a2c14125b9035d6667dcec128b41e3593d0100538a178dd5ccb0c3000ac1d5.php:1](../../system/storage/cache/template/85/85a2c14125b9035d6667dcec128b41e3593d0100538a178dd5ccb0c3000ac1d5.php#L1) |  __TwigTemplate_323b67ef9a8fc9a996b6f89c20060548c8ab6ca6e1a7aed3152a38891343d770 | `__construct()`, `doDisplay()`, `getTemplateName()`, `isTraitable()`, `getDebugInfo()`, `getSourceContext()` |
| [system/storage/cache/template/86/86455dd7561fd8ded1aec99b77b505bd1be5b49fcbd1bd42fbc777ca631edc17.php:1](../../system/storage/cache/template/86/86455dd7561fd8ded1aec99b77b505bd1be5b49fcbd1bd42fbc777ca631edc17.php#L1) |  __TwigTemplate_d7987b7c0061da95dfa286acbc8ca642471f952c421c79b78ab51297201d23ee | `__construct()`, `doDisplay()`, `getTemplateName()`, `isTraitable()`, `getDebugInfo()`, `getSourceContext()` |
| [system/storage/cache/template/87/8788545c77aec297e4e689fa0022e23652d8935285f1e308df27a219320bdd14.php:1](../../system/storage/cache/template/87/8788545c77aec297e4e689fa0022e23652d8935285f1e308df27a219320bdd14.php#L1) |  __TwigTemplate_0cde42a8672eebf9fe856c9020174707584eec5f2e1c5d6a9a1b526008b906dd | `__construct()`, `doDisplay()`, `getTemplateName()`, `isTraitable()`, `getDebugInfo()`, `getSourceContext()` |
| [system/storage/cache/template/8d/8de9a29d2eb5f62cec5315f8ad7406e93439425f2a6a1e1f73fb877dfc9b3d23.php:1](../../system/storage/cache/template/8d/8de9a29d2eb5f62cec5315f8ad7406e93439425f2a6a1e1f73fb877dfc9b3d23.php#L1) |  __TwigTemplate_40ea00b75e40f15c0d9d376adc5e8d10801570fb044e72a2dec9105335db1e23 | `__construct()`, `doDisplay()`, `getTemplateName()`, `isTraitable()`, `getDebugInfo()`, `getSourceContext()` |
| [system/storage/cache/template/8f/8f3e331fe78eceaa6f0f6129b0cd4b29df2379511d3941541cfca7e9b635043e.php:1](../../system/storage/cache/template/8f/8f3e331fe78eceaa6f0f6129b0cd4b29df2379511d3941541cfca7e9b635043e.php#L1) |  __TwigTemplate_a6649d7c068e9dbf7907c32ad1d0a399a1d7fbe3711333c74721507dae7e13f8 | `__construct()`, `doDisplay()`, `getTemplateName()`, `isTraitable()`, `getDebugInfo()`, `getSourceContext()` |
| [system/storage/cache/template/92/92faf73fbd2ccb156ee6249ea361557e3bee00f5e6bfab867c86de2cacbb8a0e.php:1](../../system/storage/cache/template/92/92faf73fbd2ccb156ee6249ea361557e3bee00f5e6bfab867c86de2cacbb8a0e.php#L1) |  __TwigTemplate_23e59930a4461a94b67d741c77c323834217049d688a700452b61af6542ba152 | `__construct()`, `doDisplay()`, `getTemplateName()`, `isTraitable()`, `getDebugInfo()`, `getSourceContext()` |
| [system/storage/cache/template/93/9372c6b9db70014efc99e5f8dec7747dda1c453681d8419bb386b4611794a4df.php:1](../../system/storage/cache/template/93/9372c6b9db70014efc99e5f8dec7747dda1c453681d8419bb386b4611794a4df.php#L1) |  __TwigTemplate_fec9336946346c192b6535ab7864eb51be0d0dfad214892b7575f046d7d1c6b0 | `__construct()`, `doDisplay()`, `getTemplateName()`, `isTraitable()`, `getDebugInfo()`, `getSourceContext()` |
| [system/storage/cache/template/95/95fc39d34a460612f4167b2bdcac446734e8a65ec631320150a1d97bf3dd42af.php:1](../../system/storage/cache/template/95/95fc39d34a460612f4167b2bdcac446734e8a65ec631320150a1d97bf3dd42af.php#L1) |  __TwigTemplate_6f3665680a291d1ccf03a9a40c863499a42f577d60430ddf50b1c189e742d002 | `__construct()`, `doDisplay()`, `updateStorageUI()`, `getTemplateName()`, `isTraitable()`, `getDebugInfo()`, `getSourceContext()` |
| [system/storage/cache/template/96/969aa9b35b02f9eaf2891d5ab691ed19.php:1](../../system/storage/cache/template/96/969aa9b35b02f9eaf2891d5ab691ed19.php#L1) |  __TwigTemplate_a4f6838579d7cf69623f1df9e678c47d | `__construct()`, `doDisplay()`, `getTemplateName()`, `isTraitable()`, `getDebugInfo()`, `getSourceContext()` |
| [system/storage/cache/template/97/972c1158340fbc9fea5e6dd719b9eac4ffafe33c589a67d15d0156c2ce98115e.php:1](../../system/storage/cache/template/97/972c1158340fbc9fea5e6dd719b9eac4ffafe33c589a67d15d0156c2ce98115e.php#L1) |  __TwigTemplate_c4899f794bbec451bf6dd7de540b838d4b27a2613f874fe75acd48a7387d788e | `__construct()`, `doDisplay()`, `getTemplateName()`, `isTraitable()`, `getDebugInfo()`, `getSourceContext()` |
| [system/storage/cache/template/9f/9f6b78ead8f1ad5a96f391ab168a3f2451380fa8a4e931a0fbb44b7e53f5cc8f.php:1](../../system/storage/cache/template/9f/9f6b78ead8f1ad5a96f391ab168a3f2451380fa8a4e931a0fbb44b7e53f5cc8f.php#L1) |  __TwigTemplate_24e0799105922f4decba6e59dbe4c48b0c1c644cdfca0d5b27e9cc638ca6b2cf | `__construct()`, `doDisplay()`, `getTemplateName()`, `isTraitable()`, `getDebugInfo()`, `getSourceContext()` |
| [system/storage/cache/template/a3/a30db10e97ae09d0d7ff889e6979e46e24bfa78a9744917805a8a7bd49f5539e.php:1](../../system/storage/cache/template/a3/a30db10e97ae09d0d7ff889e6979e46e24bfa78a9744917805a8a7bd49f5539e.php#L1) |  __TwigTemplate_d1e17b7a85128c918c4ef7b6d89c2fe7a437d335199a49bd4f943329ebc2a079 | `__construct()`, `doDisplay()`, `getTemplateName()`, `isTraitable()`, `getDebugInfo()`, `getSourceContext()` |
| [system/storage/cache/template/a9/a9388b76752679a877f250ef7ab1b99e75a818394c80083836f9a270837548c8.php:1](../../system/storage/cache/template/a9/a9388b76752679a877f250ef7ab1b99e75a818394c80083836f9a270837548c8.php#L1) |  __TwigTemplate_7f9ea0d6183d3a882b596a98f8a5ac79c3fb60a88f97d776eac5cb53b931d6fe | `__construct()`, `doDisplay()`, `getTemplateName()`, `isTraitable()`, `getDebugInfo()`, `getSourceContext()` |
| [system/storage/cache/template/ae/ae4268c07fa23359eaf29b52d672b27b5ea18f1ccdad512761a62cf9192821e3.php:1](../../system/storage/cache/template/ae/ae4268c07fa23359eaf29b52d672b27b5ea18f1ccdad512761a62cf9192821e3.php#L1) |  __TwigTemplate_26edf2c7fb47712b1547afc2dbe827a1c97966288282b374a556678dba3855c3 | `__construct()`, `doDisplay()`, `getTemplateName()`, `isTraitable()`, `getDebugInfo()`, `getSourceContext()` |
| [system/storage/cache/template/b2/b2d1586079dc55535609ee8d9692f8de748ffdabfc3bfb2d4f4068cdb5719d87.php:1](../../system/storage/cache/template/b2/b2d1586079dc55535609ee8d9692f8de748ffdabfc3bfb2d4f4068cdb5719d87.php#L1) |  __TwigTemplate_5f27573a680f25a2afee9dba9d6c1582633d4f3bcea67caaee9555f1d43a23cb | `__construct()`, `doDisplay()`, `getTemplateName()`, `isTraitable()`, `getDebugInfo()`, `getSourceContext()` |
| [system/storage/cache/template/c2/c253cc03ad748bd5ba7be4b66f9dec947eb4e4c13c68635be0323859020efe79.php:1](../../system/storage/cache/template/c2/c253cc03ad748bd5ba7be4b66f9dec947eb4e4c13c68635be0323859020efe79.php#L1) |  __TwigTemplate_37c855c0badbdb2ecb51b4c8c28b38932039634d95fbde25d27395e1d61fe162 | `__construct()`, `doDisplay()`, `showLoader()`, `closeLoader()`, `getTemplateName()`, `isTraitable()`, `getDebugInfo()`, `getSourceContext()` |
| [system/storage/cache/template/c5/c5d4cf1579ba25b29017ebcaca4735eb38695c09f5c031ab511f72a097dc28f4.php:1](../../system/storage/cache/template/c5/c5d4cf1579ba25b29017ebcaca4735eb38695c09f5c031ab511f72a097dc28f4.php#L1) |  __TwigTemplate_aa9d3ce0a04867b4807c8557db364c4a615a1e1096d13a73ac7991b4ca69b790 | `__construct()`, `doDisplay()`, `getTemplateName()`, `isTraitable()`, `getDebugInfo()`, `getSourceContext()` |
| [system/storage/cache/template/c5/c5fda5716b07f5ea33a9d2ce92172b7296fbd728245b1e6ece7691ebcac8368c.php:1](../../system/storage/cache/template/c5/c5fda5716b07f5ea33a9d2ce92172b7296fbd728245b1e6ece7691ebcac8368c.php#L1) |  __TwigTemplate_e69907d843356ded604b5f08f9b7792a6c7920788c6d7a1816a7192b0f19138e | `__construct()`, `doDisplay()`, `getTemplateName()`, `isTraitable()`, `getDebugInfo()`, `getSourceContext()` |
| [system/storage/cache/template/ca/ca7dfa45505325c2d02e387d214450a00f6dd8cda8dd6b5ba38ea2f2571255f1.php:1](../../system/storage/cache/template/ca/ca7dfa45505325c2d02e387d214450a00f6dd8cda8dd6b5ba38ea2f2571255f1.php#L1) |  __TwigTemplate_b7d1dd30f2d0ef89de3737387edc4a5fcc7436f1476f940db70b82bb916f3280 | `__construct()`, `doDisplay()`, `getTemplateName()`, `isTraitable()`, `getDebugInfo()`, `getSourceContext()` |
| [system/storage/cache/template/cc/cccc89fad5f695737d5cc9de6edd265e7b23c506d04cb248852741505aec28ce.php:1](../../system/storage/cache/template/cc/cccc89fad5f695737d5cc9de6edd265e7b23c506d04cb248852741505aec28ce.php#L1) |  __TwigTemplate_6a561f582ec4287540efb29aaf7ed67b12cf9ac4706371a15b8d79c9e68173d5 | `__construct()`, `doDisplay()`, `getTemplateName()`, `isTraitable()`, `getDebugInfo()`, `getSourceContext()` |
| [system/storage/cache/template/cc/ccf96cec42c60f76a5d2588077ea0572c1cd5fe704df5478c3c55e17d82c226e.php:1](../../system/storage/cache/template/cc/ccf96cec42c60f76a5d2588077ea0572c1cd5fe704df5478c3c55e17d82c226e.php#L1) |  __TwigTemplate_e76b2d458fb649237a22c63a19dda8d30478956fd34a6df4463286699b5302a1 | `__construct()`, `doDisplay()`, `getTemplateName()`, `isTraitable()`, `getDebugInfo()`, `getSourceContext()` |
| [system/storage/cache/template/cf/cf8cba6951186727e26f8b12c6d127afc27ee4cc4a78c63e52785b84393237c9.php:1](../../system/storage/cache/template/cf/cf8cba6951186727e26f8b12c6d127afc27ee4cc4a78c63e52785b84393237c9.php#L1) |  __TwigTemplate_d454925d42324a964db7929dda5cf65e2c753aaf85e27985a705a325c4d0a47b | `__construct()`, `doDisplay()`, `getTemplateName()`, `isTraitable()`, `getDebugInfo()`, `getSourceContext()` |
| [system/storage/cache/template/d3/d3d084c1550a5eb4cb5690d96237919ef6048f2543ef562050d5702baef4bc74.php:1](../../system/storage/cache/template/d3/d3d084c1550a5eb4cb5690d96237919ef6048f2543ef562050d5702baef4bc74.php#L1) |  __TwigTemplate_d80a5432480b19f88125b68116a023d3b2415033321b2da95f240eb6c922bee1 | `__construct()`, `doDisplay()`, `getTemplateName()`, `isTraitable()`, `getDebugInfo()`, `getSourceContext()` |
| [system/storage/cache/template/d4/d40626072f9f432c2628054c6de4a15e5cad05e9fe4f2d71908fb040e042a5b1.php:1](../../system/storage/cache/template/d4/d40626072f9f432c2628054c6de4a15e5cad05e9fe4f2d71908fb040e042a5b1.php#L1) |  __TwigTemplate_5b077c099aff302ccec78a9933eb67fb09d98d1662c3c491c8bc28f19a7a6e12 | `__construct()`, `doDisplay()`, `getTemplateName()`, `isTraitable()`, `getDebugInfo()`, `getSourceContext()` |
| [system/storage/cache/template/d5/d5042de64e9798b62f53dceaae2b69321094942a3f9794bda2b71b032687b320.php:1](../../system/storage/cache/template/d5/d5042de64e9798b62f53dceaae2b69321094942a3f9794bda2b71b032687b320.php#L1) |  __TwigTemplate_1aff7f0d6b4d517292eef9d9cf1cec5f2b0a50e58d5edc838b55d41f420a3ca5 | `__construct()`, `doDisplay()`, `getTemplateName()`, `isTraitable()`, `getDebugInfo()`, `getSourceContext()` |
| [system/storage/cache/template/d6/d6073aedd8f8b9c30e84d2946ed5a5c1abef5f5a69ebc00b8f65cd3be1b92375.php:1](../../system/storage/cache/template/d6/d6073aedd8f8b9c30e84d2946ed5a5c1abef5f5a69ebc00b8f65cd3be1b92375.php#L1) |  __TwigTemplate_224b524704c99d95c47e7e5d594b9c2c3b03428d8aeaf0354ed033cf595ca5bd | `__construct()`, `doDisplay()`, `getTemplateName()`, `isTraitable()`, `getDebugInfo()`, `getSourceContext()` |
| [system/storage/cache/template/d7/d7598cf18b466532daa4b11fbd2e3d480f81bab14e57a5560d49470203bcf0c8.php:1](../../system/storage/cache/template/d7/d7598cf18b466532daa4b11fbd2e3d480f81bab14e57a5560d49470203bcf0c8.php#L1) |  __TwigTemplate_f8eb8df04ff6c3bdec1e321421e366f55edd57a735b8a4664126b635dce6ffba | `__construct()`, `doDisplay()`, `getTemplateName()`, `isTraitable()`, `getDebugInfo()`, `getSourceContext()` |
| [system/storage/cache/template/da/daf679a4c34b2acb6321e63b97c19b0d67d6d5a1261bc1c07288b7c2497902c7.php:1](../../system/storage/cache/template/da/daf679a4c34b2acb6321e63b97c19b0d67d6d5a1261bc1c07288b7c2497902c7.php#L1) |  __TwigTemplate_f90c74831551fffbe1bc427d7064320b9917bdb12bb5fcabec4ff104b64c74ba | `__construct()`, `doDisplay()`, `getTemplateName()`, `isTraitable()`, `getDebugInfo()`, `getSourceContext()` |
| [system/storage/cache/template/df/df7d79abd9f70e6e6a154e8b5a9573579aeca377f417a929f123d0dad9bc1061.php:1](../../system/storage/cache/template/df/df7d79abd9f70e6e6a154e8b5a9573579aeca377f417a929f123d0dad9bc1061.php#L1) |  __TwigTemplate_56c9c151ca4e6f8bdd5b883e029ed5729e952aa69ef60d3602cd5e49d4987de4 | `__construct()`, `doDisplay()`, `start()`, `getTemplateName()`, `isTraitable()`, `getDebugInfo()`, `getSourceContext()` |
| [system/storage/cache/template/e6/e64dcb6fbf72a924b0b43b54569418bf7e7e794b011b56b98f82b80bd570189b.php:1](../../system/storage/cache/template/e6/e64dcb6fbf72a924b0b43b54569418bf7e7e794b011b56b98f82b80bd570189b.php#L1) |  __TwigTemplate_42dd5362e7d776cd1678358f26fbd56e6da5fd81560e67ebcab45c8d17c0cf1c | `__construct()`, `doDisplay()`, `getTemplateName()`, `isTraitable()`, `getDebugInfo()`, `getSourceContext()` |
| [system/storage/cache/template/e8/e8090d467a7908113c445ffcb6c95ef4e034559d10db05874a767f92949e5d8f.php:1](../../system/storage/cache/template/e8/e8090d467a7908113c445ffcb6c95ef4e034559d10db05874a767f92949e5d8f.php#L1) |  __TwigTemplate_4391e7fb3f6cf3621ff0b91cf793f4dddfca65c62b041afddc87d75688c1da2b | `__construct()`, `doDisplay()`, `getTemplateName()`, `isTraitable()`, `getDebugInfo()`, `getSourceContext()` |
| [system/storage/cache/template/e8/e862f4f05e92f38672a0d6b713c9b121d36ec727c8eba720c0db05f161415a2f.php:1](../../system/storage/cache/template/e8/e862f4f05e92f38672a0d6b713c9b121d36ec727c8eba720c0db05f161415a2f.php#L1) |  __TwigTemplate_96a8fcfa069bc729d6ebb08c33218601c79978c24ebf4203f8b28282d5ce7151 | `__construct()`, `doDisplay()`, `getTemplateName()`, `isTraitable()`, `getDebugInfo()`, `getSourceContext()` |
| [system/storage/cache/template/ea/ea30cc28f65592b40e3a95ad05ff678e43a1c4f5cd0e4aa9f582e75fd55d5b62.php:1](../../system/storage/cache/template/ea/ea30cc28f65592b40e3a95ad05ff678e43a1c4f5cd0e4aa9f582e75fd55d5b62.php#L1) |  __TwigTemplate_e0056b2154c6e35ae9343983aa47c79111abac0eb8f4ca222e0c75796948c500 | `__construct()`, `doDisplay()`, `getTemplateName()`, `isTraitable()`, `getDebugInfo()`, `getSourceContext()` |
| [system/storage/cache/template/ee/eebff280664d2432f53ea6f6f94731c2b2a2dbf2df148d7fff532763297ff58e.php:1](../../system/storage/cache/template/ee/eebff280664d2432f53ea6f6f94731c2b2a2dbf2df148d7fff532763297ff58e.php#L1) |  __TwigTemplate_b16b11ed95ee87cfc10b93a7ceb67db26740c4c18e7c7949aaa244cd3f2fc88d | `__construct()`, `doDisplay()`, `getTemplateName()`, `isTraitable()`, `getDebugInfo()`, `getSourceContext()` |
| [system/storage/cache/template/f2/f21d907dc92bc34af11d27052df302db4ebbb856bb6afb4675a38a1f10b4cc7a.php:1](../../system/storage/cache/template/f2/f21d907dc92bc34af11d27052df302db4ebbb856bb6afb4675a38a1f10b4cc7a.php#L1) |  __TwigTemplate_0f9a8e3c2c0204ab01445ef3ed50032822098465f540364e432b8fe7593a08a3 | `__construct()`, `doDisplay()`, `getTemplateName()`, `isTraitable()`, `getDebugInfo()`, `getSourceContext()` |
| [system/storage/cache/template/f4/f41a0eceb1b136c99362a6699126dd43de54ae528e88585aaba97656b372547c.php:1](../../system/storage/cache/template/f4/f41a0eceb1b136c99362a6699126dd43de54ae528e88585aaba97656b372547c.php#L1) |  __TwigTemplate_ffb625fe92dd0a018aa1e798d3a64fa79ec8acd3fbff0ed92630ec2c95de2170 | `__construct()`, `doDisplay()`, `start()`, `getTemplateName()`, `isTraitable()`, `getDebugInfo()`, `getSourceContext()` |
| [system/storage/cache/template/f9/f924dc9f332364bb2e6d11b3a06741f23663c6cdcbfec28caa22ad60252a5baa.php:1](../../system/storage/cache/template/f9/f924dc9f332364bb2e6d11b3a06741f23663c6cdcbfec28caa22ad60252a5baa.php#L1) |  __TwigTemplate_127de5c2294cc8bf2791883b6daa91ad92033916e31ff58e45745a27eb7db1dc | `__construct()`, `doDisplay()`, `getTemplateName()`, `isTraitable()`, `getDebugInfo()`, `getSourceContext()` |
| [system/storage/cache/template/f9/f9493f343ef20a61b5833500553e7db908a34eccb33ec1e70f3104fd54f11eb0.php:1](../../system/storage/cache/template/f9/f9493f343ef20a61b5833500553e7db908a34eccb33ec1e70f3104fd54f11eb0.php#L1) |  __TwigTemplate_ea26e635bc50f3b1fc0566c3948bac0de74993dbb3b55efb6a30d3992b028855 | `__construct()`, `doDisplay()`, `getTemplateName()`, `isTraitable()`, `getDebugInfo()`, `getSourceContext()` |
| [system/storage/cache/template/fd/fd31bf0525660aa44b83742c274b66f27522f18ee99409335f1b7e811191bb99.php:1](../../system/storage/cache/template/fd/fd31bf0525660aa44b83742c274b66f27522f18ee99409335f1b7e811191bb99.php#L1) |  __TwigTemplate_e758fca03feda232684c84762edea39402b8e3e605613f8c9fa1b4b06757e81d | `__construct()`, `doDisplay()`, `getTemplateName()`, `isTraitable()`, `getDebugInfo()`, `getSourceContext()` |

## Tham chiếu model chưa giải quyết

Các dòng dưới đây là lời gọi literal có file đích không tồn tại; không kết luận endpoint đã được thực thi hoặc đang được dùng. `install/upgrade/` chứa tham chiếu ghép động nên target literal có thể chỉ là prefix.

| Nguồn | load->model target |
|---|---|
| [admin/controller/event/statistics.php:5](../../admin/controller/event/statistics.php#L5) | `setting/statistics` |
| [admin/controller/event/statistics.php:12](../../admin/controller/event/statistics.php#L12) | `setting/statistics` |
| [admin/controller/localisation/country.php:376](../../admin/controller/localisation/country.php#L376) | `customer/customer` |
| [admin/controller/localisation/country.php:378](../../admin/controller/localisation/country.php#L378) | `localisation/geo_zone` |
| [admin/controller/localisation/zone.php:364](../../admin/controller/localisation/zone.php#L364) | `customer/customer` |
| [admin/controller/localisation/zone.php:365](../../admin/controller/localisation/zone.php#L365) | `localisation/geo_zone` |
| [admin/controller/mail/affiliate.php:4](../../admin/controller/mail/affiliate.php#L4) | `customer/customer` |
| [admin/controller/mail/affiliate.php:60](../../admin/controller/mail/affiliate.php#L60) | `customer/customer` |
| [admin/controller/mail/customer.php:4](../../admin/controller/mail/customer.php#L4) | `customer/customer` |
| [admin/controller/mail/customer.php:60](../../admin/controller/mail/customer.php#L60) | `customer/customer` |
| [admin/controller/mail/return.php:29](../../admin/controller/mail/return.php#L29) | `sale/return` |
| [admin/controller/mail/reward.php:28](../../admin/controller/mail/reward.php#L28) | `customer/customer` |
| [admin/controller/mail/transaction.php:28](../../admin/controller/mail/transaction.php#L28) | `customer/customer` |
| [admin/controller/setting/store.php:314](../../admin/controller/setting/store.php#L314) | `setting/extension` |
| [admin/controller/setting/store.php:335](../../admin/controller/setting/store.php#L335) | `design/layout` |
| [admin/controller/setting/store.php:431](../../admin/controller/setting/store.php#L431) | `localisation/location` |
| [admin/controller/setting/store.php:519](../../admin/controller/setting/store.php#L519) | `customer/customer_group` |
| [admin/controller/setting/store.php:547](../../admin/controller/setting/store.php#L547) | `catalog/information` |
| [install/controller/upgrade/upgrade.php:51](../../install/controller/upgrade/upgrade.php#L51) | `upgrade/` |

## Các dữ liệu máy đọc được

- `evidence/files.csv`: toàn bộ file gốc và hash trước khi thêm docs.
- `evidence/methods.csv`: declarations + vị trí dòng; trích xuất tĩnh, không bao gồm method kế thừa.
- `evidence/literal-loads.csv`: model/controller/view/language/library/helper/config literal. `exact_file_exists=false` chưa đồng nghĩa dependency mất: controller route có hậu tố method và một số load dùng prefix động.
- `evidence/model-calls.csv`: lời gọi `$this->model_*->method()` theo method nguồn.
- `evidence/sql-table-access.csv`: bảng tại vị trí FROM/JOIN/UPDATE/INTO/TABLE; token FROM không đồng nghĩa thao tác SELECT thuần, DELETE cũng có FROM. Không phân loại read/write chỉ từ token này.
- Các extractor dùng regex, không phải PHP AST hoặc phân tích data-flow; tên class trong comment/vendor và tham chiếu động cần đối chiếu thủ công trước khi dùng làm kết luận mới.
