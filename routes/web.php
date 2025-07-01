<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\laravel_example\UserManagement;
use App\Http\Controllers\dashboard\Analytics;
use App\Http\Controllers\dashboard\Crm;
use App\Http\Controllers\language\LanguageController;
use App\Http\Controllers\layouts\CollapsedMenu;
use App\Http\Controllers\layouts\ContentNavbar;
use App\Http\Controllers\layouts\ContentNavSidebar;
use App\Http\Controllers\layouts\Horizontal;
use App\Http\Controllers\layouts\Vertical;
use App\Http\Controllers\layouts\WithoutMenu;
use App\Http\Controllers\layouts\WithoutNavbar;
use App\Http\Controllers\layouts\Fluid;
use App\Http\Controllers\layouts\Container;
use App\Http\Controllers\layouts\Blank;
use App\Http\Controllers\front_pages\Landing;
use App\Http\Controllers\front_pages\Pricing;
use App\Http\Controllers\front_pages\Payment;
use App\Http\Controllers\front_pages\Checkout;
use App\Http\Controllers\front_pages\HelpCenter;
use App\Http\Controllers\front_pages\HelpCenterArticle;
use App\Http\Controllers\apps\Email;
use App\Http\Controllers\apps\Chat;
use App\Http\Controllers\apps\Calendar;
use App\Http\Controllers\apps\Kanban;
use App\Http\Controllers\apps\EcommerceDashboard;
use App\Http\Controllers\apps\EcommerceProductList;
use App\Http\Controllers\apps\EcommerceProductAdd;
use App\Http\Controllers\apps\EcommerceProductCategory;
use App\Http\Controllers\apps\EcommerceOrderList;
use App\Http\Controllers\apps\EcommerceOrderDetails;
use App\Http\Controllers\apps\EcommerceCustomerAll;
use App\Http\Controllers\apps\EcommerceCustomerDetailsOverview;
use App\Http\Controllers\apps\EcommerceCustomerDetailsSecurity;
use App\Http\Controllers\apps\EcommerceCustomerDetailsBilling;
use App\Http\Controllers\apps\EcommerceCustomerDetailsNotifications;
use App\Http\Controllers\apps\EcommerceManageReviews;
use App\Http\Controllers\apps\EcommerceReferrals;
use App\Http\Controllers\apps\EcommerceSettingsDetails;
use App\Http\Controllers\apps\EcommerceSettingsPayments;
use App\Http\Controllers\apps\EcommerceSettingsCheckout;
use App\Http\Controllers\apps\EcommerceSettingsShipping;
use App\Http\Controllers\apps\EcommerceSettingsLocations;
use App\Http\Controllers\apps\EcommerceSettingsNotifications;
use App\Http\Controllers\apps\AcademyDashboard;
use App\Http\Controllers\apps\AcademyCourse;
use App\Http\Controllers\apps\AcademyCourseDetails;
use App\Http\Controllers\apps\LogisticsDashboard;
use App\Http\Controllers\apps\LogisticsFleet;
use App\Http\Controllers\apps\InvoiceList;
use App\Http\Controllers\apps\InvoicePreview;
use App\Http\Controllers\apps\InvoicePrint;
use App\Http\Controllers\apps\InvoiceEdit;
use App\Http\Controllers\apps\InvoiceAdd;
use App\Http\Controllers\apps\UserList;
use App\Http\Controllers\apps\UserViewAccount;
use App\Http\Controllers\apps\UserViewSecurity;
use App\Http\Controllers\apps\UserViewBilling;
use App\Http\Controllers\apps\UserViewNotifications;
use App\Http\Controllers\apps\UserViewConnections;
use App\Http\Controllers\apps\AccessRoles;
use App\Http\Controllers\apps\AccessPermission;
use App\Http\Controllers\pages\UserProfile;
use App\Http\Controllers\pages\UserTeams;
use App\Http\Controllers\pages\UserProjects;
use App\Http\Controllers\pages\UserConnections;
use App\Http\Controllers\pages\AccountSettingsAccount;
use App\Http\Controllers\pages\AccountSettingsSecurity;
use App\Http\Controllers\pages\AccountSettingsBilling;
use App\Http\Controllers\pages\AccountSettingsNotifications;
use App\Http\Controllers\pages\AccountSettingsConnections;
use App\Http\Controllers\pages\Faq;
use App\Http\Controllers\pages\Pricing as PagesPricing;
use App\Http\Controllers\pages\MiscError;
use App\Http\Controllers\pages\HologramasValidacion;

use App\Http\Controllers\pages\MiscUnderMaintenance;
use App\Http\Controllers\pages\MiscComingSoon;
use App\Http\Controllers\pages\MiscNotAuthorized;
use App\Http\Controllers\pages\MiscServerError;
use App\Http\Controllers\authentications\LoginBasic;
use App\Http\Controllers\authentications\LoginCover;
use App\Http\Controllers\authentications\RegisterBasic;
use App\Http\Controllers\authentications\RegisterCover;
use App\Http\Controllers\authentications\RegisterMultiSteps;
use App\Http\Controllers\authentications\VerifyEmailBasic;
use App\Http\Controllers\authentications\VerifyEmailCover;
use App\Http\Controllers\authentications\ResetPasswordBasic;
use App\Http\Controllers\authentications\ResetPasswordCover;
use App\Http\Controllers\authentications\ForgotPasswordBasic;
use App\Http\Controllers\authentications\ForgotPasswordCover;
use App\Http\Controllers\authentications\TwoStepsBasic;
use App\Http\Controllers\authentications\TwoStepsCover;
use App\Http\Controllers\wizard_example\Checkout as WizardCheckout;
use App\Http\Controllers\wizard_example\PropertyListing;
use App\Http\Controllers\wizard_example\CreateDeal;
use App\Http\Controllers\modal\ModalExample;
use App\Http\Controllers\cards\CardBasic;
use App\Http\Controllers\cards\CardAdvance;
use App\Http\Controllers\cards\CardStatistics;
use App\Http\Controllers\cards\CardAnalytics;
use App\Http\Controllers\cards\CardGamifications;
use App\Http\Controllers\cards\CardActions;
use App\Http\Controllers\user_interface\Accordion;
use App\Http\Controllers\user_interface\Alerts;
use App\Http\Controllers\user_interface\Badges;
use App\Http\Controllers\user_interface\Buttons;
use App\Http\Controllers\user_interface\Carousel;
use App\Http\Controllers\user_interface\Collapse;
use App\Http\Controllers\user_interface\Dropdowns;
use App\Http\Controllers\user_interface\Footer;
use App\Http\Controllers\user_interface\ListGroups;
use App\Http\Controllers\user_interface\Modals;
use App\Http\Controllers\user_interface\Navbar;
use App\Http\Controllers\user_interface\Offcanvas;
use App\Http\Controllers\user_interface\PaginationBreadcrumbs;
use App\Http\Controllers\user_interface\Progress;
use App\Http\Controllers\user_interface\Spinners;
use App\Http\Controllers\user_interface\TabsPills;
use App\Http\Controllers\user_interface\Toasts;
use App\Http\Controllers\user_interface\TooltipsPopovers;
use App\Http\Controllers\user_interface\Typography;
use App\Http\Controllers\extended_ui\Avatar;
use App\Http\Controllers\extended_ui\BlockUI;
use App\Http\Controllers\extended_ui\DragAndDrop;
use App\Http\Controllers\extended_ui\MediaPlayer;
use App\Http\Controllers\extended_ui\PerfectScrollbar;
use App\Http\Controllers\extended_ui\StarRatings;
use App\Http\Controllers\extended_ui\SweetAlert;
use App\Http\Controllers\extended_ui\TextDivider;
use App\Http\Controllers\extended_ui\TimelineBasic;
use App\Http\Controllers\extended_ui\TimelineFullscreen;
use App\Http\Controllers\extended_ui\Tour;
use App\Http\Controllers\extended_ui\Treeview;
use App\Http\Controllers\extended_ui\Misc;
use App\Http\Controllers\icons\RiIcons;
use App\Http\Controllers\form_elements\BasicInput;
use App\Http\Controllers\form_elements\InputGroups;
use App\Http\Controllers\form_elements\CustomOptions;
use App\Http\Controllers\form_elements\Editors;
use App\Http\Controllers\form_elements\FileUpload;
use App\Http\Controllers\form_elements\Picker;
use App\Http\Controllers\form_elements\Selects;
use App\Http\Controllers\form_elements\Sliders;
use App\Http\Controllers\form_elements\Switches;
use App\Http\Controllers\form_elements\Extras;
use App\Http\Controllers\form_layouts\VerticalForm;
use App\Http\Controllers\form_layouts\HorizontalForm;
use App\Http\Controllers\form_layouts\StickyActions;
use App\Http\Controllers\form_wizard\Numbered as FormWizardNumbered;
use App\Http\Controllers\form_wizard\Icons as FormWizardIcons;
use App\Http\Controllers\form_validation\Validation;
use App\Http\Controllers\tables\Basic as TablesBasic;
use App\Http\Controllers\tables\DatatableBasic;
use App\Http\Controllers\tables\DatatableAdvanced;
use App\Http\Controllers\tables\DatatableExtensions;
use App\Http\Controllers\charts\ApexCharts;
use App\Http\Controllers\charts\ChartJs;
use App\Http\Controllers\maps\Leaflet;
use App\Http\Controllers\solicitudCliente\solicitudClienteController;
use App\Http\Controllers\pdfscontrollers\CartaAsignacionController;
use App\Http\Controllers\EnviarCorreoController;
use App\Http\Controllers\clientes\clientesProspectoController;
use App\Http\Controllers\catalogo\categoriasController;
use App\Http\Controllers\catalogo\marcasCatalogoController;
use App\Http\Controllers\catalogo\claseController;
use App\Http\Controllers\catalogo\lotesEnvasadoController;
use App\Http\Controllers\guias\GuiasController;
use App\Http\Controllers\hologramas\solicitudHologramaController;
use App\Http\Controllers\clientes\clientesConfirmadosController;
use App\Http\Controllers\documentacion\documentacionController;
use App\Http\Controllers\domicilios\DomiciliosController;
use App\Http\Controllers\domicilios\prediosController;
use App\Http\Controllers\domicilios\DestinosController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\getFuncionesController;
use App\Http\Controllers\usuarios\UsuariosController;
use App\Http\Controllers\usuarios\UsuariosInspectoresController;
use App\Http\Controllers\usuarios\UsuariosPersonalController;
use App\Http\Controllers\usuarios\UsuariosConsejoController;
use App\Http\Controllers\catalogo\lotesGranelController;
use App\Http\Controllers\documentacion\DocumentosController;
use App\Http\Controllers\solicitudes\SolicitudesTipoController;
//Tipos maguey/agave
use App\Http\Controllers\catalogo\tiposController;
use App\Http\Controllers\dictamenes\DictamenInstalacionesController;
use App\Http\Controllers\dictamenes\DictamenGranelController;
use App\Http\Controllers\dictamenes\DictamenEnvasadoController;
use App\Http\Controllers\certificados\Certificado_InstalacionesController;
use App\Http\Controllers\certificados\Certificado_GranelController;
use App\Http\Controllers\hologramas\solicitudHolograma;
use App\Http\Controllers\catalogo\catalogoEquiposController;
use App\Http\Controllers\insertar_datos_bd;
use App\Http\Controllers\inspecciones\inspeccionesController;
use App\Http\Controllers\NotificacionController;
use App\Http\Controllers\solicitudes\solicitudesController;
use App\Http\Controllers\TrazabilidadController;
use App\Http\Controllers\pdf_llenado\PdfController;
use App\Http\Controllers\revision\RevisionPersonalController;
use App\Http\Controllers\revision\RevisionConsejoController;
use App\Http\Controllers\revision\catalogo_personal_seleccion_preguntas_controller;
use App\Http\Controllers\bitacoras\BitacoraMezcalController;
use App\Http\Controllers\bitacoras\BitacoraProductoMaduracionController;
use App\Http\Controllers\bitacoras\BitacoraProcesoElaboracionController;
use App\Http\Controllers\bitacoras\BitacoraProductoTerminadoController;
use App\Http\Controllers\bitacoras\BitacoraHologramasController;
use App\Http\Controllers\catalogo\EtiquetasController;
use App\Http\Controllers\certificados\Certificado_ExportacionController;
use App\Http\Controllers\certificados\Certificado_NacionalController;
use App\Http\Controllers\insertar_datos_bd_certificados;
use App\Http\Controllers\insertar_datos_bd_dictamenes;
use App\Http\Controllers\Tramite_impi\impiController;
use App\Http\Controllers\dictamenes\DictamenExportacionController;
use App\Http\Controllers\clientes\resumenController;
use App\Http\Controllers\DocuSignController;
use App\Http\Controllers\efirma\firmaController;
use App\Http\Controllers\hologramas\hologramasACtivar;
use App\Http\Controllers\insertar_datos_bd_actas;
use App\Http\Controllers\insertar_datos_bd_certificados_granel;
use App\Http\Controllers\insertar_datos_bd_dictamenes_exportacion;
use App\Http\Controllers\insertar_datos_bd_dictamenes_graneles;
use App\Http\Controllers\insertar_datos_bd_lotes_envasado;
use App\Http\Controllers\insertar_datos_bd_predios;
use App\Http\Controllers\permisos\permisosController;
use App\Http\Controllers\permisos\rolesController;

// Main Page Route
//Route::get('/', [Analytics::class, 'index'])->name('dashboard-analytics');
Route::get('/', function () {
    return redirect('/login');
});

Route::get('/docusign/authenticate', [DocuSignController::class, 'authenticate'])->name('docusign');
Route::get('/test-docusign', [DocuSignController::class, 'sendDocument'])->name('test-docusign');
Route::get('/obtenerTokenDocuSign', [DocuSignController::class, 'obtenerTokenDocuSign'])->name('obtenerTokenDocuSign');
Route::post('/docusign/enviar', [DocuSignController::class, 'sendDocument2'])->name('docusign.enviar')->middleware('auth');
Route::get('/docusign/sendDocumentAuto', [DocuSignController::class, 'sendDocumentAuto'])->name('docusign.enviar.auto');

Route::get('/docusign/firma-completada', [DocuSignController::class, 'firmaCompletada'])->name('firma.completada');
Route::get('/docusign/descargar/{envelopeId}', [DocuSignController::class, 'descargarDocumento'])->name('docusign.descargar');
Route::get('/estadoSobre/{envelopeId}', [DocuSignController::class, 'estadoSobre'])->name('estadoSobre');
Route::get('/add_firmar_docusign', [DocuSignController::class, 'add_firmar_docusign'])->name('add_firmar_docusign');



//Para documentos
Route::get('files/{filename}', [FileController::class, 'show'])
    ->name('file.show')
    ->middleware('auth'); // Middleware para autenticar usuarios

    Route::get('files/{carpeta}/{filename}', [FileController::class, 'show2'])
    ->name('file.show2');
     Route::get('files/{carpeta}/{carpeta2}/{filename}', [FileController::class, 'show3'])
    ->name('file.show3')
    ->middleware('auth'); // Middleware para autenticar usuarios

Route::get('/dashboard/analytics', [Analytics::class, 'index'])->name('dashboard-analytics');
Route::get('/dashboard/crm', [Crm::class, 'index'])->name('dashboard-crm');
// locale
Route::get('/lang/{locale}', [LanguageController::class, 'swap']);

// layout
Route::get('/layouts/collapsed-menu', [CollapsedMenu::class, 'index'])->name('layouts-collapsed-menu');
Route::get('/layouts/content-navbar', [ContentNavbar::class, 'index'])->name('layouts-content-navbar');
Route::get('/layouts/content-nav-sidebar', [ContentNavSidebar::class, 'index'])->name('layouts-content-nav-sidebar');
Route::get('/layouts/horizontal', [Horizontal::class, 'index'])->name('dashboard-analytics');
Route::get('/layouts/vertical', [Vertical::class, 'index'])->name('dashboard-analytics');
Route::get('/layouts/without-menu', [WithoutMenu::class, 'index'])->name('layouts-without-menu');
Route::get('/layouts/without-navbar', [WithoutNavbar::class, 'index'])->name('layouts-without-navbar');
Route::get('/layouts/fluid', [Fluid::class, 'index'])->name('layouts-fluid');
Route::get('/layouts/container', [Container::class, 'index'])->name('layouts-container');
Route::get('/layouts/blank', [Blank::class, 'index'])->name('layouts-blank');

// Front Pages
Route::get('/front-pages/landing', [Landing::class, 'index'])->name('front-pages-landing');
Route::get('/front-pages/pricing', [Pricing::class, 'index'])->name('front-pages-pricing');
Route::get('/front-pages/payment', [Payment::class, 'index'])->name('front-pages-payment');
Route::get('/front-pages/checkout', [Checkout::class, 'index'])->name('front-pages-checkout');
Route::get('/front-pages/help-center', [HelpCenter::class, 'index'])->name('front-pages-help-center');
Route::get('/front-pages/help-center-article', [HelpCenterArticle::class, 'index'])->name('front-pages-help-center-article');

// apps
Route::get('/app/email', [Email::class, 'index'])->name('app-email');
Route::get('/app/chat', [Chat::class, 'index'])->name('app-chat');
Route::get('/app/calendar', [Calendar::class, 'index'])->name('app-calendar');
Route::get('/app/kanban', [Kanban::class, 'index'])->name('app-kanban');
Route::get('/app/ecommerce/dashboard', [EcommerceDashboard::class, 'index'])->name('app-ecommerce-dashboard');
Route::get('/app/ecommerce/product/list', [EcommerceProductList::class, 'index'])->name('app-ecommerce-product-list');
Route::get('/app/ecommerce/product/add', [EcommerceProductAdd::class, 'index'])->name('app-ecommerce-product-add');
Route::get('/app/ecommerce/product/category', [EcommerceProductCategory::class, 'index'])->name('app-ecommerce-product-category');
Route::get('/app/ecommerce/order/list', [EcommerceOrderList::class, 'index'])->name('app-ecommerce-order-list');
Route::get('/app/ecommerce/order/details', [EcommerceOrderDetails::class, 'index'])->name('app-ecommerce-order-details');
Route::get('/app/ecommerce/customer/all', [EcommerceCustomerAll::class, 'index'])->name('app-ecommerce-customer-all');
Route::get('/app/ecommerce/customer/details/overview', [EcommerceCustomerDetailsOverview::class, 'index'])->name('app-ecommerce-customer-details-overview');
Route::get('/app/ecommerce/customer/details/security', [EcommerceCustomerDetailsSecurity::class, 'index'])->name('app-ecommerce-customer-details-security');
Route::get('/app/ecommerce/customer/details/billing', [EcommerceCustomerDetailsBilling::class, 'index'])->name('app-ecommerce-customer-details-billing');
Route::get('/app/ecommerce/customer/details/notifications', [EcommerceCustomerDetailsNotifications::class, 'index'])->name('app-ecommerce-customer-details-notifications');
Route::get('/app/ecommerce/manage/reviews', [EcommerceManageReviews::class, 'index'])->name('app-ecommerce-manage-reviews');
Route::get('/app/ecommerce/referrals', [EcommerceReferrals::class, 'index'])->name('app-ecommerce-referrals');
Route::get('/app/ecommerce/settings/details', [EcommerceSettingsDetails::class, 'index'])->name('app-ecommerce-settings-details');
Route::get('/app/ecommerce/settings/payments', [EcommerceSettingsPayments::class, 'index'])->name('app-ecommerce-settings-payments');
Route::get('/app/ecommerce/settings/checkout', [EcommerceSettingsCheckout::class, 'index'])->name('app-ecommerce-settings-checkout');
Route::get('/app/ecommerce/settings/shipping', [EcommerceSettingsShipping::class, 'index'])->name('app-ecommerce-settings-shipping');
Route::get('/app/ecommerce/settings/locations', [EcommerceSettingsLocations::class, 'index'])->name('app-ecommerce-settings-locations');
Route::get('/app/ecommerce/settings/notifications', [EcommerceSettingsNotifications::class, 'index'])->name('app-ecommerce-settings-notifications');
Route::get('/app/academy/dashboard', [AcademyDashboard::class, 'index'])->name('app-academy-dashboard');
Route::get('/app/academy/course', [AcademyCourse::class, 'index'])->name('app-academy-course');
Route::get('/app/academy/course-details', [AcademyCourseDetails::class, 'index'])->name('app-academy-course-details');
Route::get('/app/logistics/dashboard', [LogisticsDashboard::class, 'index'])->name('app-logistics-dashboard');
Route::get('/app/logistics/fleet', [LogisticsFleet::class, 'index'])->name('app-logistics-fleet');
Route::get('/app/invoice/list', [InvoiceList::class, 'index'])->name('app-invoice-list');
Route::get('/app/invoice/preview', [InvoicePreview::class, 'index'])->name('app-invoice-preview');
Route::get('/app/invoice/print', [InvoicePrint::class, 'index'])->name('app-invoice-print');
Route::get('/app/invoice/edit', [InvoiceEdit::class, 'index'])->name('app-invoice-edit');
Route::get('/app/invoice/add', [InvoiceAdd::class, 'index'])->name('app-invoice-add');
Route::get('/app/user/list', [UserList::class, 'index'])->name('app-user-list');
Route::get('/app/user/view/account', [UserViewAccount::class, 'index'])->name('app-user-view-account');
Route::get('/app/user/view/security', [UserViewSecurity::class, 'index'])->name('app-user-view-security');
Route::get('/app/user/view/billing', [UserViewBilling::class, 'index'])->name('app-user-view-billing');
Route::get('/app/user/view/notifications', [UserViewNotifications::class, 'index'])->name('app-user-view-notifications');
Route::get('/app/user/view/connections', [UserViewConnections::class, 'index'])->name('app-user-view-connections');
Route::get('/app/access-roles', [AccessRoles::class, 'index'])->name('app-access-roles');
Route::get('/app/access-permission', [AccessPermission::class, 'index'])->name('app-access-permission');

// pages
Route::get('/pages/profile-user', [UserProfile::class, 'index'])->name('pages-profile-user');
Route::get('/pages/profile-teams', [UserTeams::class, 'index'])->name('pages-profile-teams');
Route::get('/pages/profile-projects', [UserProjects::class, 'index'])->name('pages-profile-projects');
Route::get('/pages/profile-connections', [UserConnections::class, 'index'])->name('pages-profile-connections');
Route::get('/pages/account-settings-account', [AccountSettingsAccount::class, 'index'])->name('pages-account-settings-account');
Route::get('/pages/account-settings-security', [AccountSettingsSecurity::class, 'index'])->name('pages-account-settings-security');
Route::get('/pages/account-settings-billing', [AccountSettingsBilling::class, 'index'])->name('pages-account-settings-billing');
Route::get('/pages/account-settings-notifications', [AccountSettingsNotifications::class, 'index'])->name('pages-account-settings-notifications');
Route::get('/pages/account-settings-connections', [AccountSettingsConnections::class, 'index'])->name('pages-account-settings-connections');
Route::get('/pages/faq', [Faq::class, 'index'])->name('pages-faq')->middleware(['auth']);
Route::get('/pages/pricing', [PagesPricing::class, 'index'])->name('pages-pricing');
Route::get('/pages/misc-error', [MiscError::class, 'index'])->name('pages-misc-error');
Route::get('/holograma/{folio}', [HologramasValidacion::class, 'index2'])->name('pages-hologramas-validacion');
Route::get('/validar_dictamen', [HologramasValidacion::class, 'validar_dictamen'])->name('validar_dictamen');

Route::get('/pages/misc-under-maintenance', [MiscUnderMaintenance::class, 'index'])->name('pages-misc-under-maintenance');
Route::get('/pages/misc-comingsoon', [MiscComingSoon::class, 'index'])->name('pages-misc-comingsoon');
Route::get('/pages/misc-not-authorized', [MiscNotAuthorized::class, 'index'])->name('pages-misc-not-authorized');
Route::get('/pages/misc-server-error', [MiscServerError::class, 'index'])->name('pages-misc-server-error');

// authentication
Route::get('/auth/login-basic', [LoginBasic::class, 'index'])->name('auth-login-basic');
Route::get('/auth/login-cover', [LoginCover::class, 'index'])->name('auth-login-cover');
Route::get('/auth/register-basic', [RegisterBasic::class, 'index'])->name('auth-register-basic');
Route::get('/auth/register-cover', [RegisterCover::class, 'index'])->name('auth-register-cover');
Route::get('/auth/register-multisteps', [RegisterMultiSteps::class, 'index'])->name('auth-register-multisteps');
Route::get('/auth/verify-email-basic', [VerifyEmailBasic::class, 'index'])->name('auth-verify-email-basic');
Route::get('/auth/verify-email-cover', [VerifyEmailCover::class, 'index'])->name('auth-verify-email-cover');
Route::get('/auth/reset-password-basic', [ResetPasswordBasic::class, 'index'])->name('auth-reset-password-basic');
Route::get('/auth/reset-password-cover', [ResetPasswordCover::class, 'index'])->name('auth-reset-password-cover');
Route::get('/auth/forgot-password-basic', [ForgotPasswordBasic::class, 'index'])->name('auth-reset-password-basic');
Route::get('/auth/forgot-password-cover', [ForgotPasswordCover::class, 'index'])->name('auth-forgot-password-cover');
Route::get('/auth/two-steps-basic', [TwoStepsBasic::class, 'index'])->name('auth-two-steps-basic');
Route::get('/auth/two-steps-cover', [TwoStepsCover::class, 'index'])->name('auth-two-steps-cover');

// wizard example
Route::get('/wizard/ex-checkout', [WizardCheckout::class, 'index'])->name('wizard-ex-checkout');
Route::get('/wizard/ex-property-listing', [PropertyListing::class, 'index'])->name('wizard-ex-property-listing');
Route::get('/wizard/ex-create-deal', [CreateDeal::class, 'index'])->name('wizard-ex-create-deal');

// modal
Route::get('/modal-examples', [ModalExample::class, 'index'])->name('modal-examples');

// cards
Route::get('/cards/basic', [CardBasic::class, 'index'])->name('cards-basic');
Route::get('/cards/advance', [CardAdvance::class, 'index'])->name('cards-advance');
Route::get('/cards/statistics', [CardStatistics::class, 'index'])->name('cards-statistics');
Route::get('/cards/analytics', [CardAnalytics::class, 'index'])->name('cards-analytics');
Route::get('/cards/gamifications', [CardGamifications::class, 'index'])->name('cards-gamifications');
Route::get('/cards/actions', [CardActions::class, 'index'])->name('cards-actions');

// User Interface
Route::get('/ui/accordion', [Accordion::class, 'index'])->name('ui-accordion');
Route::get('/ui/alerts', [Alerts::class, 'index'])->name('ui-alerts');
Route::get('/ui/badges', [Badges::class, 'index'])->name('ui-badges');
Route::get('/ui/buttons', [Buttons::class, 'index'])->name('ui-buttons');
Route::get('/ui/carousel', [Carousel::class, 'index'])->name('ui-carousel');
Route::get('/ui/collapse', [Collapse::class, 'index'])->name('ui-collapse');
Route::get('/ui/dropdowns', [Dropdowns::class, 'index'])->name('ui-dropdowns');
Route::get('/ui/footer', [Footer::class, 'index'])->name('ui-footer');
Route::get('/ui/list-groups', [ListGroups::class, 'index'])->name('ui-list-groups');
Route::get('/ui/modals', [Modals::class, 'index'])->name('ui-modals');
Route::get('/ui/navbar', [Navbar::class, 'index'])->name('ui-navbar');
Route::get('/ui/offcanvas', [Offcanvas::class, 'index'])->name('ui-offcanvas');
Route::get('/ui/pagination-breadcrumbs', [PaginationBreadcrumbs::class, 'index'])->name('ui-pagination-breadcrumbs');
Route::get('/ui/progress', [Progress::class, 'index'])->name('ui-progress');
Route::get('/ui/spinners', [Spinners::class, 'index'])->name('ui-spinners');
Route::get('/ui/tabs-pills', [TabsPills::class, 'index'])->name('ui-tabs-pills');
Route::get('/ui/toasts', [Toasts::class, 'index'])->name('ui-toasts');
Route::get('/ui/tooltips-popovers', [TooltipsPopovers::class, 'index'])->name('ui-tooltips-popovers');
Route::get('/ui/typography', [Typography::class, 'index'])->name('ui-typography');

// extended ui
Route::get('/extended/ui-avatar', [Avatar::class, 'index'])->name('extended-ui-avatar');
Route::get('/extended/ui-blockui', [BlockUI::class, 'index'])->name('extended-ui-blockui');
Route::get('/extended/ui-drag-and-drop', [DragAndDrop::class, 'index'])->name('extended-ui-drag-and-drop');
Route::get('/extended/ui-media-player', [MediaPlayer::class, 'index'])->name('extended-ui-media-player');
Route::get('/extended/ui-perfect-scrollbar', [PerfectScrollbar::class, 'index'])->name('extended-ui-perfect-scrollbar');
Route::get('/extended/ui-star-ratings', [StarRatings::class, 'index'])->name('extended-ui-star-ratings');
Route::get('/extended/ui-sweetalert2', [SweetAlert::class, 'index'])->name('extended-ui-sweetalert2');
Route::get('/extended/ui-text-divider', [TextDivider::class, 'index'])->name('extended-ui-text-divider');
Route::get('/extended/ui-timeline-basic', [TimelineBasic::class, 'index'])->name('extended-ui-timeline-basic');
Route::get('/extended/ui-timeline-fullscreen', [TimelineFullscreen::class, 'index'])->name('extended-ui-timeline-fullscreen');
Route::get('/extended/ui-tour', [Tour::class, 'index'])->name('extended-ui-tour');
Route::get('/extended/ui-treeview', [Treeview::class, 'index'])->name('extended-ui-treeview');
Route::get('/extended/ui-misc', [Misc::class, 'index'])->name('extended-ui-misc');

// icons
Route::get('/icons/icons-ri', [RiIcons::class, 'index'])->name('icons-ri');

// form elements
Route::get('/forms/basic-inputs', [BasicInput::class, 'index'])->name('forms-basic-inputs');
Route::get('/forms/input-groups', [InputGroups::class, 'index'])->name('forms-input-groups');
Route::get('/forms/custom-options', [CustomOptions::class, 'index'])->name('forms-custom-options');
Route::get('/forms/editors', [Editors::class, 'index'])->name('forms-editors');
Route::get('/forms/file-upload', [FileUpload::class, 'index'])->name('forms-file-upload');
Route::get('/forms/pickers', [Picker::class, 'index'])->name('forms-pickers');
Route::get('/forms/selects', [Selects::class, 'index'])->name('forms-selects');
Route::get('/forms/sliders', [Sliders::class, 'index'])->name('forms-sliders');
Route::get('/forms/switches', [Switches::class, 'index'])->name('forms-switches');
Route::get('/forms/extras', [Extras::class, 'index'])->name('forms-extras');

// form layouts
Route::get('/form/layouts-vertical', [VerticalForm::class, 'index'])->name('form-layouts-vertical');
Route::get('/form/layouts-horizontal', [HorizontalForm::class, 'index'])->name('form-layouts-horizontal');
Route::get('/form/layouts-sticky', [StickyActions::class, 'index'])->name('form-layouts-sticky');

// form wizards
Route::get('/form/wizard-numbered', [FormWizardNumbered::class, 'index'])->name('form-wizard-numbered');
Route::get('/form/wizard-icons', [FormWizardIcons::class, 'index'])->name('form-wizard-icons');
Route::get('/form/validation', [Validation::class, 'index'])->name('form-validation');

// tables
Route::get('/tables/basic', [TablesBasic::class, 'index'])->name('tables-basic');
Route::get('/tables/datatables-basic', [DatatableBasic::class, 'index'])->name('tables-datatables-basic');
Route::get('/tables/datatables-advanced', [DatatableAdvanced::class, 'index'])->name('tables-datatables-advanced');
Route::get('/tables/datatables-extensions', [DatatableExtensions::class, 'index'])->name('tables-datatables-extensions');

// charts
Route::get('/charts/apex', [ApexCharts::class, 'index'])->name('charts-apex');
Route::get('/charts/chartjs', [ChartJs::class, 'index'])->name('charts-chartjs');

// maps
Route::get('/maps/leaflet', [Leaflet::class, 'index'])->name('maps-leaflet');

// laravel example
Route::get('/laravel/user-management', [UserManagement::class, 'UserManagement'])->name('laravel-example-user-management');
Route::resource('/user-list', UserManagement::class);

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
     Route::get('/dashboard', [Analytics::class, 'index'])->name('dashboard');
     Route::get('/estadisticas/certificados', [Analytics::class, 'estadisticasCertificados'])->name('estadisticasCertificados');
     Route::get('/estadisticas/servicios', [Analytics::class, 'estadisticasServicios'])->name('estadisticasServicios');
});

//Solicitud de Cliente
Route::get('/solicitud-cliente', [solicitudClienteController::class, 'index'])->name('solicitud-cliente');
Route::post('/solicitud-cliente-registrar', [solicitudClienteController::class, 'registrar'])->name('solicitud-cliente-registrar');

//Vista formulario registro exitoso
Route::get('/Registro_exitoso', [solicitudClienteController::class, 'RegistroExitoso'])->name('Registro_exitoso');

//Enviar Correo
Route::get('/enviar-correo', [EnviarCorreoController::class, 'enviarCorreo']);

//Solicitud PDFs
Route::get('/carta_asignacion', [CartaAsignacionController::class, 'index'])->name('carta_asignacion');
Route::get('/solicitudinfo_cliente/{id}', [clientesProspectoController::class, 'info'])->name('solicitud_cliente');
Route::get('/asignacion_usuario', [CartaAsignacionController::class, 'access_user'])->name('asignacion_usuario');
Route::get('/prestacion_servicio_fisica/{id}', [clientesConfirmadosController::class, 'pdfServicioPersonaFisica070'])->name('prestacion_servicio_fisica');
Route::get('/prestacion_servicio_moral/{id}', [clientesConfirmadosController::class, 'pdfServicioPersonaMoral070'])->name('prestacion_servicio_moral');
Route::get('/Contrato_NMX-052', [CartaAsignacionController::class, 'CONTRATO_NMX_052'])->name('Contrato_NMX-052');
Route::get('/Contrato_prestacion_servicio_NOM-199', [CartaAsignacionController::class, 'Contrato_prestacion_servicio_NOM_199'])->name('Contrato_prestacion_servicio_NOM-199');
Route::get('/solicitud_Info_ClienteNOM-199', [CartaAsignacionController::class, 'solicitudInfoNOM_199'])->name('solicitud_Info_ClienteNOM-199');
Route::get('/inspeccion_geo_referenciacion', [CartaAsignacionController::class, 'InspeccionGeoReferenciacion'])->name('inspeccion_geo_referenciacion');
Route::get('/dictamen_cumplimiento_mezcal_granel', [CartaAsignacionController::class, 'dictamenDeCumplimientoGranel'])->name('dictamen-cumplimiento-granel');
Route::get('/bitacora_revision_SCFI2016', [CartaAsignacionController::class, 'bitacora_revision_SCFI2016'])->name('bitacora_revision_SCFI2016');
Route::get('/plan_de_auditoria', [CartaAsignacionController::class, 'PlanDeAuditoria'])->name('PlanDeAuditoria');
Route::get('/generate-pdf', [PdfController::class, 'generatePdf']);
Route::get('/certificado_de_conformidad', [CartaAsignacionController::class, 'CertificadoConformidad199'])->name('CertificadoConformidad199');
Route::get('/certificado_como_productor', [CartaAsignacionController::class, 'CertificadoComoProductor'])->name('CertificadoComoProductor');
Route::get('/certificado_como_comercializador', [CartaAsignacionController::class, 'CertificadoComoComercializador'])->name('CertificadoComoComercializador');
Route::get('/certificado_como_envasador', [CartaAsignacionController::class, 'CertificadoComoEnvasador'])->name('CertificadoComoEnvasador');
Route::get('/solicitud_de_servicios', [CartaAsignacionController::class, 'SolicitudDeServicios052'])->name('CertificadoComoEnvasador');
Route::get('/dictamen_cumplimiento_instalaciones', [CartaAsignacionController::class, 'DictamenDeCumplimienoInstalaciones'])->name('DictamenDeCumplimienoInstalaciones');
Route::get('/carta_asignacion', [CartaAsignacionController::class, 'Contancia_trabajo'])->name('Contancia_trabajo');
Route::get('/informe_inspeccion_etiqueta', [CartaAsignacionController::class, 'InformeInspeccionEtiqueta'])->name('InformeInspeccionEtiqueta');

Route::get('/informe_resultados', [CartaAsignacionController::class, 'informeresulta'])->name('informeresultados');


/* orden-trabajo-inspeccion-etiquetas */
Route::get('/orden_trabajo_inspeccion_etiquetas', [CartaAsignacionController::class, 'OrdenTrabajoInspeccionEtiquetas'])->name('OrdenTrabajoInspeccionEtiquetas');
/* lista_verificacion_nom051-mod20200327_solrev005 */
Route::get('/lista_verificacion_nom051-mod20200327_solrev005', [CartaAsignacionController::class, 'ListaVerificacionNom051Mod20200327Solrev005'])->name('ListaVerificacionNom051Mod20200327Solrev005');

//Etiquetas Etiqueta_Barrica
Route::get('/Etiqueta-2401ESPTOB', [CartaAsignacionController::class, 'Etiqueta'])->name('Etiqueta-2401ESPTOB')->middleware(['auth']);
Route::get('/Etiqueta-Muestra', [CartaAsignacionController::class, 'Etiqueta_muestra'])->name('Etiqueta-Muestra')->middleware(['auth']);
Route::get('/Etiqueta-Barrica', [CartaAsignacionController::class, 'Etiqueta_Barrica'])->name('Etiqueta-Barrica')->middleware(['auth']);

Route::get('/Etiqueta_lotes_mezcal_granel', [CartaAsignacionController::class, 'Etiqueta_Granel'])->middleware(['auth']);

Route::get('/certificado_de_exportacion', [CartaAsignacionController::class, 'certificadoDeExportacion'])->name('certificadoExportacion')->middleware(['auth']);

//Certificados de instalaciones
Route::get('/certificado_comercializador', [CartaAsignacionController::class, 'certificadocom'])->name('certificado_comercializador')->middleware(['auth']);
Route::get('/certificado_envasador_mezcal', [CartaAsignacionController::class, 'certificadoenv'])->name('certificado_envasador_mezcal')->middleware(['auth']);
Route::get('/certificado_productor_mezcal', [CartaAsignacionController::class, 'certificadoprod'])->name('certificado_productor_mezcal')->middleware(['auth']);

//Clientes prospecto y confirmado
Route::get('/clientes/prospecto', [clientesProspectoController::class, 'UserManagement'])->name('clientes-prospecto')->middleware(['auth']);
Route::resource('/empresas-list', clientesProspectoController::class)->middleware(['auth']);
Route::get('/clientes-list/{id}/edit', [clientesProspectoController::class, 'edit'])->middleware(['auth']);
Route::post('/clientes/{id}/update', [clientesProspectoController::class, 'update'])->name('clientes.update')->middleware(['auth']);
Route::get('/solicitudInfoClienteNOM-199/{id}', [clientesProspectoController::class, 'pdfNOM199'])->middleware(['auth']);

Route::post('/aceptar-cliente', [clientesProspectoController::class, 'aceptarCliente'])->middleware(['auth']);
Route::get('/lista_empresas/{id}', [getFuncionesController::class, 'find_clientes_prospecto'])->middleware(['auth']);
Route::get('/lista_inspetores', [getFuncionesController::class, 'usuariosInspectores'])->middleware(['auth']);
Route::get('/datosComunes/{id_empresa}', [getFuncionesController::class, 'datosComunes'])->middleware(['auth']);

/*obtener el editar*/
Route::get('/cliente_confirmado/{id}/edit', [clientesConfirmadosController::class, 'editarCliente'])->name('editarCliente')->middleware(['auth']);
/*editar*/
Route::put('/cliente_confirmado/{id}', [clientesConfirmadosController::class, 'update_cliente'])->name('editarCliente')->middleware(['auth']);

Route::get('/clientes/confirmados', [clientesConfirmadosController::class, 'UserManagement'])->name('clientes-confirmados')->middleware(['auth']);
Route::resource('/clientes-list', clientesConfirmadosController::class)->middleware(['auth']);
Route::get('/carta_asignacion/{id}', [clientesConfirmadosController::class, 'pdfCartaAsignacion'])->name('carta_asignacion')->middleware(['auth']);
Route::get('/carta_asignacion052/{id}', [clientesConfirmadosController::class, 'pdfCartaAsignacion052'])->name('carta_asignacion052')->middleware(['auth']);

//Marcas y catalogo
Route::get('/catalogo/marcas', [marcasCatalogoController::class, 'UserManagement'])->name('catalogo-marcas')->middleware(['auth']);
Route::resource('/catalago-list', marcasCatalogoController::class)->middleware(['auth']);
Route::resource('marcas-list', marcasCatalogoController::class)->except(['create', 'edit'])->middleware(['auth']);
Route::get('/marcas-list/{id}/edit', [marcasCatalogoController::class, 'edit'])->name('marcas.edit')->middleware(['auth']);
Route::post('/marcas-list/{id}', [marcasCatalogoController::class, 'store'])->middleware(['auth']);
Route::post('/update-fecha-vigencia/{id_documento}', [marcasCatalogoController::class, 'updateFechaVigencia'])->middleware(['auth']);
Route::post('/marcas-list/update', [marcasCatalogoController::class, 'update'])->name('marcas.update')->middleware(['auth']);
Route::post('/marcas-list/update', [marcasCatalogoController::class, 'update'])->name('marcas.update')->middleware(['auth']);
Route::post('/etiquetado/updateEtiquetas', [marcasCatalogoController::class, 'updateEtiquetas'])->middleware(['auth']);
Route::get('/marcas-list/{id}/editEtiquetas', [marcasCatalogoController::class, 'editEtiquetas'])->name('marcas.edit')->middleware(['auth']);

//Etiquetas
Route::get('/catalogo/etiquetas', [EtiquetasController::class, 'UserManagement'])->name('catalogo-etiquetas')->middleware(['auth']);
Route::resource('/etiquetas-list', EtiquetasController::class)->middleware(['auth']);
Route::post('/registrar-etiqueta', [EtiquetasController::class, 'store'])->middleware(['auth']);
Route::get('/edit-etiqueta/{id_etiqueta}', [EtiquetasController::class, 'edit_etiqueta'])->middleware(['auth']);
Route::get('/destinos-por-empresa/{id_empresa}', [EtiquetasController::class, 'getDestinosPorEmpresa']);
//oute::get('/eliminar-etiqueta/{id_etiqueta}', [EtiquetasController::class, 'destroy']);

/* ruta de clases catalogo */
Route::get('/catalogo/clases', [claseController::class, 'UserManagement'])->name('catalogo-clases')->middleware(['auth']);
Route::get('/clases-list', [claseController::class, 'index'])->middleware(['auth']);
Route::delete('/clases-list/{id_clase}', [claseController::class, 'destroy'])->name('clases.destroy')->middleware(['auth']);
Route::post('/catalogo', [claseController::class, 'store'])->name('catalogo.store')->middleware(['auth']);
Route::get('/clases-list/{id_clase}/edit', [claseController::class, 'edit'])->name('clases.edit')->middleware(['auth']);
Route::post('/clases-list/{id_clase}', [claseController::class, 'update'])->name('clases.update')->middleware(['auth']);

//Categorias Agave
Route::get('/catalogo/categorias', [categoriasController::class, 'UserManagement'])->name('catalogo-categorias')->middleware(['auth']);
Route::resource('/categorias-list', categoriasController::class)->middleware(['auth']);
Route::delete('categorias/{id_categoria}', [categoriasController::class, 'destroy'])->name('categorias.destroy')->middleware(['auth']);
Route::post('/categorias', [categoriasController::class, 'store'])->name('categorias.store')->middleware(['auth']);
Route::get('/categorias-list/{id_categoria}/edit', [categoriasController::class, 'edit'])->name('categoria.edit')->middleware(['auth']);
Route::put('/categorias-list/{id_categoria}', [categoriasController::class, 'update'])->name('categoria.update')->middleware(['auth']);

Route::get('/catalogo/lotes_granel', [lotesGranelController::class, 'UserManagement'])->name('catalogo-lotes-granel')->middleware(['auth']);
Route::resource('/lotes-granel-list', lotesGranelController::class)->middleware(['auth']);
Route::delete('/lotes-granel-list/{id_lote_granel}', [lotesGranelController::class, 'destroy'])->middleware(['auth']);
Route::post('/lotes-register/store', [lotesGranelController::class, 'store'])->name('lotes-register.store')->middleware(['auth']);
Route::get('/lotes-a-granel/{id_lote_granel}/edit', [lotesGranelController::class, 'edit'])->name('lotes-a-granel.edit')->middleware(['auth']);
Route::post('/lotes-a-granel/{id_lote_granel}', [lotesGranelController::class, 'update'])->middleware(['auth']);
Route::get('/lotes-a-granel/{id_lote_granel}/volumen', [lotesGranelController::class, 'getVolumen'])->name('lotes-a-granel.volumen')->middleware(['auth']);
Route::post('/eliminar_documento', [lotesGranelController::class, 'eliminar_documento'])->name('documento.eliminar');


//Lotes de envasado
Route::get('/catalogo/lotes', [LotesEnvasadoController::class, 'UserManagement'])->name('catalogo-lotes')->middleware(['auth']);
Route::resource('/lotes-list', LotesEnvasadoController::class)->middleware(['auth']);
Route::post('/lotes-envasado', [LotesEnvasadoController::class, 'store'])->middleware(['auth']);
Route::get('/lotes-envasado/edit/{id}', [lotesEnvasadoController::class, 'edit'])->middleware(['auth']);
Route::post('/lotes-envasado/update/', [lotesEnvasadoController::class, 'update'])->middleware(['auth']);
Route::get('/lotes-envasado/editSKU/{id}', [lotesEnvasadoController::class, 'editSKU'])->middleware(['auth']);
Route::post('/lotes-envasado/updateSKU/', [lotesEnvasadoController::class, 'updateSKU'])->middleware(['auth']);
Route::get('/obtenerDocumentos/{id_marca}', [LotesEnvasadoController::class, 'obtenerDocumentosPorMarca']);

//Domicilios fiscal
Route::get('/domicilios/fiscal', [ClaseController::class, 'UserManagement'])->name('domicilio_fiscal')->middleware(['auth']);

//Domicilios Instalaciones
Route::get('/domicilios/instalaciones', [DomiciliosController::class, 'UserManagement'])->name('domicilio-instalaciones')->middleware(['auth']);
Route::resource('/instalaciones-list', DomiciliosController::class)->middleware(['auth']);
Route::delete('instalaciones/{id_instalacion}', [DomiciliosController::class, 'destroy'])->middleware(['auth']);
Route::post('/instalaciones', [DomiciliosController::class, 'store'])->middleware(['auth']);
Route::get('domicilios/edit/{id_instalacion}', [DomiciliosController::class, 'edit'])->name('domicilios.edit')->middleware(['auth']);
Route::put('instalaciones/{id_instalacion}', [DomiciliosController::class, 'update'])->middleware(['auth']);
Route::get('/getDocumentosPorInstalacion', [DomiciliosController::class, 'getDocumentosPorInstalacion'])->middleware(['auth']);

//Domicilio predios
Route::get('/domicilios/predios', [PrediosController::class, 'UserManagement'])->name('domicilios-predios')->middleware(['auth']);
Route::resource('/predios-list', PrediosController::class)->middleware(['auth']);
Route::delete('/predios-list/{id_predio}', [PrediosController::class, 'destroy'])->name('predios-list.destroy')->middleware(['auth']);
Route::post('/predios-register/store', [PrediosController::class, 'store'])->name('predios-register.store')->middleware(['auth']);
Route::get('/domicilios-predios/{id_predio}/edit', [PrediosController::class, 'edit'])->name('domicilios-predios.edit')->middleware(['auth']);
Route::post('/domicilios-predios/{id_predio}', [PrediosController::class, 'update'])->name('domicilios-predios.update')->middleware(['auth']);
Route::post('/domicilios-predios/{id_predio}/inspeccion', [PrediosController::class, 'inspeccion'])->name('domicilios-predios.inspeccion')->middleware(['auth']);
Route::post('/domicilios-predios/{id_predio}/inspeccion-update', [PrediosController::class, 'inspeccion_update'])->name('domicilios-predios.inspeccion-update')->middleware(['auth']);
Route::get('/domicilios-predios/{id_predio}/edit-inspeccion', [PrediosController::class, 'editInspeccion'])->name('domicilios-predios.edit-inspeccion')->middleware(['auth']);
Route::get('/pre-registro_predios/{id_predio}', [prediosController::class, 'PdfPreRegistroPredios'])->name('pre-registro_predios')->middleware(['auth']);
Route::get('/inspeccion_geo_referenciacion/{id_predio}', [prediosController::class, 'PDFInspeccionGeoReferenciacion'])->name('inspeccion_geo_referenciacion')->middleware(['auth']);
Route::get('/Registro_de_Predios_Maguey_Agave/{id_predio}', [prediosController::class, 'PDFRegistroPredios'])->name('PDF_Registro_Predios')->middleware(['auth']);
Route::post('/registro-Predio/{id_predio}', [PrediosController::class, 'registroPredio'])->name('registro-predios.registroPredio')->middleware(['auth']);
Route::post('/edit-registro-Predio/{id_predio}', [PrediosController::class, 'editRegistroPredio'])->name('registro-predios.editRegistroPredio')->middleware(['auth']);
Route::get('/solicitudServicio/{id_predio}', [PrediosController::class, 'pdf_solicitud_servicios_070'])->middleware(['auth']);

//Domicilio Destinos
Route::get('/domicilios/destinos', [DestinosController::class, 'UserManagement'])->name('domicilio-destinos')->middleware(['auth']);
Route::resource('/destinos-list', DestinosController::class)->middleware(['auth']);
Route::delete('/destinos-list/{id_direccion}', [DestinosController::class, 'destroy'])->name('destinos-list.destroy')->middleware(['auth']);
Route::post('/destinos-register/{id_direccion}', [DestinosController::class, 'store'])->name('destinos-register.store')->middleware(['auth']);
/* route::get('/destinos-list/{id_direccion}/edit', [DestinoController::class, 'edit'])->name('destinos.edit');
 */route::post('/destinos-update/{id_direccion}', [DestinosController::class, 'update'])->name('destinos.update')->middleware(['auth']);

//Usuarios
Route::get('/usuarios/clientes', [UsuariosController::class, 'UserManagement'])->name('usuarios-clientes')->middleware(['auth']);
Route::resource('/user-list', UsuariosController::class)->middleware(['auth']);
Route::get('/pdf_asignacion_usuario/{id}', [UsuariosController::class, 'pdfAsignacionUsuario'])->name('pdf_asignacion_usuario')->middleware(['auth']);

Route::get('/usuarios/inspectores', [UsuariosInspectoresController::class, 'inspectores'])->name('usuarios-inspectores')->middleware(['auth']);
Route::resource('/inspectores-list', UsuariosInspectoresController::class)->middleware(['auth']);

Route::get('/usuarios/personal', [UsuariosPersonalController::class, 'personal'])->name('usuarios-personal')->middleware(['auth']);
Route::resource('/personal-list', UsuariosPersonalController::class)->middleware(['auth']);

//Consejo usuarios
Route::get('/usuarios/consejo', [UsuariosConsejoController::class, 'consejo'])->name('usuarios-consejo')->middleware(['auth']);
Route::resource('/consejo-list', UsuariosConsejoController::class)->middleware(['auth']);

Route::middleware(['auth'])->group(function () {

    Route::get('/find_roles', [rolesController::class, 'find_roles'])->name('find_roles');
    Route::resource('/roles-list', rolesController::class);

    Route::get('/find_permisos', [permisosController::class, 'find_permisos'])->name('find_permisos');
    Route::resource('/permisos-list', permisosController::class);
});

//Documentacion
Route::middleware(['auth'])->group(function () {
    Route::get('/documentacion', [documentacionController::class, 'index'])->name('documentacion');
    Route::get('/documentacion/getNormas', [documentacionController::class, 'getNormas'])->name('documentacion.getNormas');
    Route::get('/documentacion/getActividades', [documentacionController::class, 'getActividades'])->name('documentacion.getActividades');
    Route::post('/upload', [documentacionController::class, 'upload'])->name('upload');
    Route::delete('/eliminar-documento/{id}', [documentacionController::class, 'eliminarDocumento'])->name('eliminarDocumento');
});

//-------------------TIPOS DE MAGUEY/AGAVE-------------------
Route::middleware(['auth'])->controller(tiposController::class)->group(function () {
    /*mostrar*/
    Route::get('/catalogo/tipos', [tiposController::class, 'UserManagement'])->name('catalogo-tipos');
    Route::resource('/tipos-list', tiposController::class);
    /*eliminar*/
    Route::delete('/tipos-list/{id_tipo}', [tiposController::class, 'destroy'])->name('tipos.destroy');
    /*registrar*/
    Route::post('/tipos-list', [tiposController::class, 'store'])->name('tipo.store');
    /*obtener el editar*/
    Route::get('/edit-list/{id_tipo}/edit', [tiposController::class, 'edit'])->name('tipos.edit');
    /*editar*/
    Route::put('/edit-list/{id_tipo}', [tiposController::class, 'update'])->name('tipos.update');
});


Route::get('/getDatos/{empresa}', [getFuncionesController::class, 'getDatos'])->name('getDatos');
Route::get('/getDatosLoteEnvasado/{idLoteEnvasado}', [getFuncionesController::class, 'getDatosLoteEnvasado']);

Route::get('/getDatos2/{lote_granel}', [getFuncionesController::class, 'getDatos2'])->name('getDatos2');
Route::get('/getDatosSolicitud/{id_solicitud}', [getFuncionesController::class, 'getDatosSolicitud'])->name('getDatosSolicitud');
Route::get('/obtenerDocumentosClientes/{id_documento}/{id_cliente}', [getFuncionesController::class, 'obtenerDocumentosClientes'])->name('obtenerDocumentosClientes');


//Guias de agave o maguey
Route::get('/guias/guias_de_agave', [GuiasController::class, 'UserManagement'])->name('traslado-guias')->middleware(['auth']);
Route::resource('/guias-list', GuiasController::class)->middleware(['auth']);
Route::post('/guias/store', [GuiasController::class, 'store'])->middleware(['auth']);
Route::get('/guia_de_translado/{id_guia}', [GuiasController::class, 'guiasTranslado'])->name('Guias_Translado')->middleware(['auth']);
Route::get('/edit/{id_guia}', [GuiasController::class, 'edit'])->name('guias.edit')->middleware(['auth']);
Route::post('/update', [GuiasController::class, 'update'])->name('guias.update')->middleware(['auth']);
Route::get('/editGuias/{run_folio}', [GuiasController::class, 'editGuias'])->middleware(['auth']);

//Route::get('/guias/getPlantaciones/{id_predio}', [GuiasController::class, 'getPlantacionesByPredio']);


//Documentacion
Route::get('/documentos', [DocumentosController::class, 'UserManagement'])->name('catalogo-documentos')->middleware(['auth']);
Route::resource('/documentos-list', DocumentosController::class)->middleware(['auth']);
Route::delete('/documentos/{id}', [DocumentosController::class, 'destroy'])->name('documentos.destroy')->middleware(['auth']);
Route::post('/documentos', [DocumentosController::class, 'store'])->middleware(['auth']);

// Ruta para obtener los datos del documento para editar
Route::get('/documentos/{id}/edit', [DocumentosController::class, 'edit'])->middleware(['auth']);

// Ruta para actualizar el documento
Route::put('/documentos/{id}', [DocumentosController::class, 'update'])->middleware(['auth']);

//-------------------INSPECCIONES-------------------
Route::middleware(['auth'])->controller(inspeccionesController::class)->group(function () {
    Route::get('/inspecciones', 'UserManagement')->name('inspecciones');
    Route::resource('inspecciones-list', inspeccionesController::class);
    Route::post('/asignar-inspector', 'asignarInspector');
    Route::get('/oficio_de_comision/{id_inspeccion}', 'pdf_oficio_comision')->name('oficioDeComision');
    Route::get('/etiqueta_agave_art/{id_inspeccion}', 'etiqueta_muestra')->name('etiqueta-muestra');
    Route::get('/orden_de_servicio/{id_inspeccion}', 'pdf_orden_servicio')->name('ordenDeServicio');
    Route::get('/etiqueta_lotes_mezcal_granel/{id_inspeccion}', 'etiqueta_granel')->name('etiquetalotegranel');
    Route::get('/etiqueta-barrica/{id_inspeccion}',  'etiqueta_barrica')->name('etiquetabarrica');
    Route::get('/etiquetas_tapas_sellado/{id_inspeccion}', 'etiqueta')->name('etiqueta-2401ESPTOB');
    Route::post('/agregar-resultados', 'agregarResultados');
    Route::get('/acta-solicitud/edit/{id_acta}', 'editActa');
    Route::get('/getInspeccion/{id_solicitud}', 'getInspeccion');
    //pdf rutas
    Route::post('/acta-unidades', [inspeccionesController::class, 'store'])->name('acta.unidades.store');
    Route::get('/acta_circunstanciada_unidades_produccion/{id_inspeccion}', [inspeccionesController::class, 'acta_circunstanciada_produccion'])->name('acta_circunstanciada_unidades_produccion');
    Route::get('/inspecciones/exportar', 'exportar')->name('inspecciones.exportar');
   /*  Route::get('/getDatosSolicitud/{id_solicitud}',  'getDatosSolicitud')->name('getDatosSolicitud'); */
});

//-------------------HOLOGRAMAS - SOLICITUD DE HOLOGRAMAS-------------------
Route::middleware(['auth'])->controller(solicitudHolograma::class)->group(function () {
    Route::get('/hologramas/solicitud', [solicitudHolograma::class, 'UserManagement'])->name('hologramas-solicitud');
    Route::resource('/hologramas-list', solicitudHolograma::class);
    Route::post('/hologramas/store', [solicitudHolograma::class, 'store']);
    Route::get('/solicitud_holograma/edit/{id_solicitud}', [solicitudHolograma::class, 'edit']);
    Route::post('/solicitud_holograma/update/', [solicitudHolograma::class, 'update']);
    Route::get('/solicitud_de_holograma/{id}', [solicitudHolograma::class, 'ModelsSolicitudHolograma'])->name('solicitudDeHologramas');
    Route::post('/solicitud_holograma/update2', [solicitudHolograma::class, 'update2']);
    Route::post('/solicitud_holograma/update3', [solicitudHolograma::class, 'update3']);
    Route::post('/solicitud_holograma/updateAsignar', [solicitudHolograma::class, 'updateAsignar']);
    Route::post('/solicitud_holograma/updateRecepcion', [solicitudHolograma::class, 'updateRecepcion']);

    Route::get('/solicitud_holograma/editActivos/{id}', [solicitudHolograma::class, 'editActivos']);
    Route::get('/solicitud_holograma/editActivados/{id}', [solicitudHolograma::class, 'editActivados']);

    //solicitud hologrammas
    Route::post('/solicitud_holograma/update/updateActivar', [solicitudHolograma::class, 'updateActivar']);
});

//-------------------ACTIVACION DE HOLOGRAMAS-------------------
Route::middleware(['auth'])->controller(hologramasACtivar::class)->group(function () {
    Route::get('/find_hologramas_activar', [hologramasACtivar::class, 'find_hologramas_activar'])->name('hologramas-activar');
    Route::resource('/find_hologramas_activar-list', hologramasACtivar::class);
    Route::get('/getDatosInpeccion/{id_inspeccion}','getDatosInpeccion');
    Route::post('/verificar-folios', 'verificarFolios');
    Route::post('/solicitud_holograma/storeActivar', 'storeActivar');
    Route::get('/activacion_holograma/edit/{id}', [hologramasACtivar::class, 'editActivados']);
    Route::post('/solicitud_holograma/update/updateActivados', [hologramasACtivar::class, 'updateActivados']);
});


Route::get('/marcas/{id_empresa}', [lotesEnvasadoController::class, 'obtenerMarcasPorEmpresa']);


//Tipo
Route::get('/solicitudes', [SolicitudesTipoController::class, 'UserManagement'])->name('solicitudes-tipo')->middleware(['auth']);
Route::get('solicitudes/tipos', [SolicitudesTipoController::class, 'getSolicitudesTipos'])->name('obtener.solicitudes.tipos')->middleware(['auth']);

//Notificaciones
Route::post('/notificacion-leida/{id}', [NotificacionController::class, 'marcarNotificacionLeida'])->name('notificacion.leida')->middleware(['auth']);


//-------------------TRAZABILIDAD-------------------
Route::middleware(['auth'])->controller(TrazabilidadController::class)->group(function () {
    Route::get('/trazabilidad/{id}', [TrazabilidadController::class, 'mostrarLogs'])->name('mostrarLogs');
    Route::get('/trazabilidad-certificados/{id}', [TrazabilidadController::class, 'TrackingCertificados'])->name('trazabilidad de certificados');
});

Route::get('/Plan-auditoria-esquema', [CartaAsignacionController::class, 'PlanAuditoria'])->name('Plan-auditoria-esquema')->middleware(['auth']);
Route::get('/Reporte-Tecnico', [CartaAsignacionController::class, 'ReporteTecnico'])->name('Reporte-Tecnico')->middleware(['auth']);
Route::get('/Dictamen-MezcalEnvasado', [CartaAsignacionController::class, 'DictamenMezcalEnvasado'])->name('Dictamen-MezcalEnvasado')->middleware(['auth']);
Route::get('/Plan-auditoria-esquema', [CartaAsignacionController::class, 'PlanAuditoria'])->name('Plan-auditoria-esquema')->middleware(['auth']);
Route::get('/Reporte-Tecnico', [CartaAsignacionController::class, 'ReporteTecnico'])->name('Reporte-Tecnico')->middleware(['auth']);
Route::get('/Solicitud-Especificaciones', [CartaAsignacionController::class, 'SolicitudEspecificaciones'])->name('Solicitud-Especificaciones')->middleware(['auth']);
Route::get('/Oreden-Trabajo', [CartaAsignacionController::class, 'OrdenTrabajo'])->name('Oreden-Trabajo')->middleware(['auth']);
Route::get('/Solicitud-Servicio-UNIIC', [CartaAsignacionController::class, 'SolicitudUNIIC'])->name('Solicitud-Servicio-UNIIC')->middleware(['auth']);

Route::get('/empresa_contrato/{id_empresa}', [clientesConfirmadosController::class, 'obtenerContratosPorEmpresa'])->middleware(['auth']);
Route::get('/edit_cliente_confirmado/{id_empresa}', [clientesConfirmadosController::class, 'edit_cliente_confirmado'])->middleware(['auth']);
Route::get('/empresa_num_cliente/{id_empresa}', [clientesConfirmadosController::class, 'obtenerNumeroCliente'])->middleware(['auth']);
Route::post('/actualizar-registros', [clientesConfirmadosController::class, 'actualizarRegistros'])->middleware(['auth']);
Route::post('/editar_cliente_confirmado', [clientesConfirmadosController::class, 'editar_cliente_confirmado'])->middleware(['auth']);
Route::delete('clientes-list/{id_empresa}', [clientesConfirmadosController::class, 'destroy'])->name('')->middleware(['auth']);
Route::post('/registrar-clientes', [ClientesConfirmadosController::class, 'registrarClientes'])->name('clientes.registrar')->middleware(['auth']);


//-------------------MODULO DE SOLICITUDES-------------------
Route::middleware(['auth'])->controller(solicitudesController::class)->group(function () {
    Route::get('/solicitudes-historial', 'UserManagement')->name('solicitudes-historial');
    Route::resource('/solicitudes-list', solicitudesController::class);
    Route::get('/solicitud_de_servicio/{id_solicitud}', 'pdf_solicitud_servicios_070')->name('solicitudservi');
    Route::post('/registrar-solicitud-georeferenciacion', 'registrarSolicitudGeoreferenciacion')->name('registrarSolicitudGeoreferenciacion');
    Route::post('/registrar-solicitud-muestreo-agave', 'registrarSolicitudMuestreoAgave')->name('registrarSolicitudMuestreoAgave');
    Route::post('/hologramas/storeVigilanciaProduccion', 'storeVigilanciaProduccion');
    Route::post('/hologramas/storeMuestreoLote', 'storeMuestreoLote');
    Route::post('/hologramas/storeVigilanciaTraslado', 'storeVigilanciaTraslado');
    Route::post('/hologramas/storeInspeccionBarricada', 'storeInspeccionBarricada');
    Route::post('/hologramas/storeInspeccionBarricadaLiberacion', 'storeInspeccionBarricadaLiberacion');
    Route::post('/hologramas/storeInspeccionEnvasado', 'storeInspeccionEnvasado');
    Route::post('/storeEmisionCertificadoVentaNacional', 'storeEmisionCertificadoVentaNacional');
    Route::get('/getDetalleLoteTipo/{id_tipo}', 'getDetalleLoteTipo');
    Route::delete('/solicitudes-lista/{id_solicitud}', 'destroy')->name('solicitudes-list.destroy');
    Route::get('/getDetalleLoteEnvasado/{id_lote_envasado}', 'getDetalleLoteEnvasado');
    Route::get('/verificar-solicitud', 'verificarSolicitud')->name('verificarSolicitud');
    Route::get('/datos-solicitud/{id_solicitud}',  'obtenerDatosSolicitud')->name('datos.solicitud');
    Route::post('/actualizar-solicitudes/{id_solicitud}', 'actualizarSolicitudes');
    Route::post('/exportaciones/storePedidoExportacion', 'storePedidoExportacion')->name('exportaciones.storePedidoExportacion');
    Route::get('/marcas/{id_marca}/{id_direccion}', 'obtenerMarcasPorEmpresa');
    Route::get('/solicitudes/exportar', 'exportar')->name('solicitudes.exportar');
    Route::post('/registrar-solicitud-lib-prod-term','storeSolicitudLibProdTerm');
    Route::get('/Etiqueta-2401ESPTOB/{id_solicitud}', 'Etiqueta_240');
    Route::post('/registrarValidarSolicitud', 'registrarValidarSolicitud');
    Route::get('/pdf_validar_solicitud/{id_validacion}', 'pdf_validar_solicitud');

    Route::get('/obtener_dictamenes_envasado/{empresa}', [getFuncionesController::class, 'getDictamenesEnvasado'])->name('getDictamenesEnvasado');
    Route::get('/obtener_datos_inspeccion_dictamen/{id}', [getFuncionesController::class, 'obtenerDatosInspeccion']);
    Route::get('/getDocumentosSolicitud/{id_solicitud}', [getFuncionesController::class, 'getDocumentosSolicitud']);


});

//-------------------CATALOGO EQUIPOS-------------------
Route::middleware(['auth'])->controller(catalogoEquiposController::class)->group(function () {
    Route::get('/catalogo/equipos', [catalogoEquiposController::class, 'UserManagement'])->name('catalogo-equipos');
    Route::resource('/equipos-list', catalogoEquiposController::class);
    Route::post('/equipos/store', [catalogoEquiposController::class, 'store'])->name('equipos.store');
    Route::get('/equipos-list/{id_equipo}/edit', [catalogoEquiposController::class, 'edit'])->name('equipos.edit');
    Route::post('/equipos-list/update', [catalogoEquiposController::class, 'update'])->name('equipos.update');
});

//-------------------REVISION PERSONAL-------------------
Route::middleware(['auth'])->controller(RevisionPersonalController::class)->group(function () {
    Route::get('/revision/personal', 'UserManagement')->name('revision-personal');
    Route::resource('/revision-personal-list', RevisionPersonalController::class);
    Route::post('/revisor/registrar-respuestas', 'registrarRespuestas')->name('registrar.respuestas');
    Route::get('/revisor/obtener-respuestas/{id_revision}', 'obtenerRespuestas');
    Route::get('/get-certificado-url/{id_revision}/{tipo}', 'getCertificadoUrl');
    Route::get('/bitacora_revisionPersonal_Instalaciones/{id}', 'Bitacora_revisionPersonal_Instalaciones');
    Route::post('/registrar-aprobacion', 'registrarAprobacion')->name('registrar.aprobacion');
    Route::get('/aprobacion/{id}', 'cargarAprobacion');
    Route::get('/obtener/historial/{id_revision}', 'cargarHistorial');
    Route::post('/editar-respuestas', 'editinsertarCertificadosGranelDesdeAPIarRespuestas');
    // -Granel-
    Route::get('/bitacora_revisionPersonal_Granel/{id}', 'Bitacora_revisionPersonal_Granel');

    Route::get('/add_revision/{id_revision}', 'add_revision');
    Route::post('registrar_revision', 'registrar_revision')->name('registrar_revision');
    Route::get('/edit_revision/{id_revision}', 'edit_revision');
    Route::post('editar_revision', 'editar_revision')->name('editar_revision');
    Route::get('/pdf_bitacora_revision_personal/{id}', 'pdf_bitacora_revision_personal');
});


//-------------------REVISION CONSEJO-------------------
Route::middleware(['auth'])->controller(RevisionConsejoController::class)->group(function () {
/*   Route::get('/pdf/solicitud-exportacion/{id_revision}', [RevisionConsejoController::class, 'mostrarSolicitudPDFDesdeRevision'])
    ->name('revision.pdf.solicitud_exportacion'); */
  Route::get('/solicitud_certificado_exportacion/{id_certificado}', [Certificado_ExportacionController::class, 'MostrarSolicitudCertificadoExportacion'])
      ->name('PDF-SOL-cer-exportacion');
/*     Route::get('/solicitud_certificado_exportacion/{id_certificado}', 'MostrarSolicitudCertificadoExportacion')->name('PDF-SOL-cer-exportacion');
 */
    Route::get('/revision/consejo', 'UserManagement')->name('revision-consejo');
    Route::resource('/revision-consejo-list', RevisionConsejoController::class);
    Route::post('/revisor/registrar-respuestas-consejo', 'registrarRespuestasConsejo')->name('registrar.respuestas.consejo');
    Route::get('/revisor/obtener-respuestas-consejo/{id_revision}', 'obtenerRespuestasConsejo');
    Route::get('/get-certificado-url-consejo/{id_revision}/{tipo}', 'getCertificadoUrlConsejo');
    Route::get('/bitacora_revisionConsejo_Instalaciones/{id}', 'Bitacora_revisionConsejo_Instalaciones');
    Route::post('/registrar-aprobacion-consejo', 'registrarAprobacionConsejo')->name('registrar.aprobacion.consejo');
    Route::get('/aprobacion-consejo/{id}', 'cargarAprobacionConsejo');
    Route::get('/obtener/historial-consejo/{id_revision}', 'cargarHistorialConsejo');
    Route::post('/editar-respuestas-consejo', 'editinsertarCertificadosGranelDesdeAPIarRespuestasConsejo');
    // -Granel-
    Route::get('/bitacora_revisionConsejo_Granel/{id}', 'Bitacora_revisionConsejo_Granel');
    Route::get('/add_revision_consejo/{id_revision}', 'add_revision_consejo');
    Route::post('registrar_revision_consejo', 'registrar_revision_consejo')->name('registrar_revision_consejo');
    Route::get('/edit_revision_consejo/{id_revision}', 'edit_revision_consejo');
    Route::post('editar_revision_consejo', 'editar_revision_consejo')->name('editar_revision_consejo');
    Route::get('/pdf_bitacora_revision_consejo/{id}', 'pdf_bitacora_revision_consejo');
    Route::get('/pdf_bitacora_revision_certificado_instalaciones/{id}', 'pdf_bitacora_revision_certificado_instalaciones');
    Route::get('/pdf_bitacora_revision_certificado_granel/{id}', 'pdf_bitacora_revision_certificado_granel');
    Route::get('/pdf_bitacora_revision_certificado_exportacion/{id}', 'pdf_bitacora_revision_certificado_exportacion');

});

// Pdfs Bitacoras
Route::get('/bitacora_maduracion', [CartaAsignacionController::class, 'BitacoraMaduracion'])->name('bitacora_maduracion');
Route::get('/bitacora_productor', [CartaAsignacionController::class, 'BitacoraProductor'])->name('bitacora_productor');
Route::get('/bitacora_terminado', [CartaAsignacionController::class, 'BitacoraTerminado'])->name('bitacora_terminado');
Route::get('/bitacora_hologramas', [CartaAsignacionController::class, 'BitacoraHologramas'])->name('bitacora_hologramas');

// BitacoraMezcal
Route::get('/bitacoraMezcal', [BitacoraMezcalController::class, 'UserManagement'])->name('bitacora-mezcal');
Route::resource('/bitacoraMezcal-list', BitacoraMezcalController::class);
Route::get('/bitacora_mezcal', [BitacoraMezcalController::class, 'PDFBitacoraMezcal']);
Route::get('bitacoraMezcal-list/{id_bitacora}', [BitacoraMezcalController::class, 'destroy'])->name('bitacora.delete');
Route::post('/bitacoraMezcalStore', [BitacoraMezcalController::class, 'store'])->name('bitacora.store');
Route::get('/bitacora_mezcal/{id_bitacora}/edit', [BitacoraMezcalController::class, 'edit'])->name('bitacora_mezcal.edit');
Route::post('/bitacorasUpdate/{id_bitacora}', [BitacoraMezcalController::class, 'update'])->name('bitacoras.update');


// BitacoraMaduracion
Route::get('/bitacoraProductoMaduracion', [BitacoraProductoMaduracionController::class, 'UserManagement'])->name('bitacoraProductoMaduracion');
Route::resource('/bitacoraProductoMaduracion-list', BitacoraProductoMaduracionController::class);

// BitacoraProcesoElaboracion
Route::get('/bitacoraProcesoElaboracion', [BitacoraProcesoElaboracionController::class, 'UserManagement'])->name('bitacoraProcesoElaboracion');
Route::resource('/bitacoraProcesoElaboracion-list', BitacoraProcesoElaboracionController::class);

// BitacorProductoTerminado
Route::get('/bitacoraProductoTerminado', [BitacoraProductoTerminadoController::class, 'UserManagement'])->name('bitacoraProductoTerminado');
Route::resource('/bitacoraProductoTerminado-list', BitacoraProductoTerminadoController::class);

// BitacorHologramas
Route::get('/bitacoraHologramas', [BitacoraHologramasController::class, 'UserManagement'])->name('bitacoraHologramas');
Route::resource('/bitacoraHologramas-list', BitacoraHologramasController::class);


Route::get('/insertarSolicitudesDesdeAPI', [insertar_datos_bd::class, 'insertarSolicitudesDesdeAPI'])->name('insertarSolicitudesDesdeAPI');
Route::get('/insertarDictamenesDesdeAPI', [insertar_datos_bd_dictamenes::class, 'insertarDictamenesDesdeAPI'])->name('insertarDictamenesDesdeAPI');
Route::get('/insertarDictamenesGranelesDesdeAPI', [insertar_datos_bd_dictamenes_graneles::class, 'insertarDictamenesGranelesDesdeAPI'])->name('insertarDictamenesGranelesDesdeAPI');
Route::get('/insertarDictamenesExportacionDesdeAPI', [insertar_datos_bd_dictamenes_exportacion::class, 'insertarDictamenesExportacionDesdeAPI'])->name('insertarDictamenesExportacionDesdeAPI');
Route::get('/insertarCertificadosDesdeAPI', [insertar_datos_bd_certificados::class, 'insertarCertificadosDesdeAPI'])->name('insertarCertificadosDesdeAPI');
Route::get('/insertarCertificadosGranelDesdeAPI', [insertar_datos_bd_certificados_granel::class, 'insertarCertificadosGranelDesdeAPI'])->name('insertarCertificadosGranelDesdeAPI');
Route::get('/insertarActasDesdeAPI', [insertar_datos_bd_actas::class, 'insertarActasDesdeAPI'])->name('insertarActasDesdeAPI');
Route::get('/insertarLotesEnvasadoDesdeAPI', [insertar_datos_bd_lotes_envasado::class, 'insertarLotesEnvasadoDesdeAPI'])->name('insertarLotesEnvasadoDesdeAPI');
Route::get('/insertarPrediosDesdeAPI', [insertar_datos_bd_predios::class, 'insertarPrediosDesdeAPI'])->name('insertarPrediosDesdeAPI');




//-------------------DICTAMEN INSTALACIONES-------------------
Route::middleware(['auth'])->controller(DictamenInstalacionesController::class)->group(function () {
    // Rutas principales
    Route::get('dictamenes/instalaciones', 'UserManagement')->name('dictamenes-instalaciones');
    Route::resource('insta', DictamenInstalacionesController::class);
    // Rutas específicas para eliminar, registrar y editar
    Route::delete('insta/{id_dictamen}', 'destroy')->name('instalacion.delete');
    Route::post('insta', 'store')->name('instalacion.store');
    Route::get('insta/{id_dictamen}/edit', 'edit')->name('instalacion.edit');
    Route::post('insta/{id_dictamen}', 'update')->name('tipos.update');
    Route::post('/registrar/reexpedir-instalaciones', [DictamenInstalacionesController::class, 'reexpedir'])->name('dic-insta.reex');
    // Rutas para generación de PDFs de dictámenes
    Route::get('/dictamen_productor/{id_dictamen}', 'dictamen_productor')->name('dictamen_productor');
    Route::get('/dictamen_envasador/{id_dictamen}', 'dictamen_envasador')->name('dictamen_envasador');
    Route::get('/dictamen_comercializador/{id_dictamen}', 'dictamen_comercializador')->name('dictamen_comercializador');
    Route::get('/dictamen_almacen/{id_dictamen}', 'dictamen_almacen')->name('dictamen_almacen');
    Route::get('/dictamen_maduracion/{id_dictamen}', 'dictamen_maduracion')->name('dictamen_maduracion');
});

//-------------------DICTAMEN GRANEL-------------------
Route::middleware(['auth'])->group(function () {//agrupa distintos controladores
    Route::get('/dictamenes/granel', [DictamenGranelController::class, 'UserManagement'])->name('dictamenes-granel');
    Route::resource('/dictamen-granel-list', DictamenGranelController::class);
    Route::delete('dictamen/granel/{id_dictamen}', [DictamenGranelController::class, 'destroy'])->name('dictamen.delete');
    Route::post('dictamenes-granel',[DictamenGranelController::class, 'store'])->name('dictamen.store');
    route::get('/dictamenes/granel/{id_dictamen}/edit', [DictamenGranelController::class, 'edit'])->name('dictamenes.edit');
    Route::post('/dictamenes/granel/{id_dictamen}/update', [DictamenGranelController::class, 'update'])->name('dictamen.update');
    //Route::get('/dictamenes/granel/{id_dictamen}/foliofq', [DictamenGranelController::class, 'foliofq'])->name('dictamenes.foliofq');
    Route::post('/registrar/reexpedir-granel', [DictamenGranelController::class, 'reexpedir'])->name('dic-granel.reex');
    Route::get('/dictamen_granel/{id_dictamen}', [DictamenGranelController::class, 'MostrarDictamenGranel'])->name('formato-dictamen-granel');
    Route::get('/getDatosLotes/{id_inspeccion}', [DictamenGranelController::class, 'getDatosLotes'])->name('getDatosLotes');
});

//-------------------DICTAMEN ENVASADO-------------------
Route::middleware(['auth'])->group(function () {//agrupa distintos controladores
    Route::get('/dictamenes/envasado', [DictamenEnvasadoController::class, 'UserManagement'])->name('dictamenes-envasado');
    Route::resource('/dictamen-envasado-list', DictamenEnvasadoController::class);
    Route::delete('dictamen/envasado/{id_dictamen}', [DictamenEnvasadoController::class, 'destroy'])->name('dictamen.delete');
    Route::post('dictamenes-envasado',[DictamenEnvasadoController::class, 'store'])->name('dictamen.store');
    route::get('/dictamenes/envasado/{id_dictamen}/edit', [DictamenEnvasadoController::class, 'edit'])->name('dictamenes.edit');
    Route::post('/dictamenes/envasado/{id_dictamen}/update', [DictamenEnvasadoController::class, 'update'])->name('dictamen.update');
    Route::post('/registrar/reexpedir-envasado', [DictamenEnvasadoController::class, 'reexpedir'])->name('dic-envasado.reex');
    Route::get('/dictamen_envasado/{id_dictamen}', [DictamenEnvasadoController::class, 'MostrarDictamenEnvasado'])->name('formato-dictamen-envasado');
    Route::get('/getDatosLotesEnv/{id_inspeccion}', [DictamenEnvasadoController::class, 'getDatosLotesEnv'])->name('getDatosLotesEnv');
});

//-------------------DICTAMEN EXPORTACION-------------------
Route::middleware(['auth'])->controller(DictamenExportacionController::class)->group(function () {
    Route::get('dictamenes/exportacion', 'UserManagement')->name('dictamenes-exportacion');
    Route::resource('expor-list', DictamenExportacionController::class);
    //Registrar
    Route::post('registrar', 'store')->name('dic-expor.create');
    ///Eliminar
    Route::delete('eliminar2/{id_dictamen}', 'destroy')->name('instalacion.delete');
    ///Obtener Editar
    Route::get('editar2/{id_dictamen}/edit', 'edit')->name('instalacion.edit');
    ///Editar
    Route::post('editar2/{id_dictamen}', 'update')->name('tipos.update');
    // Ruta PDF con ID
    Route::get('/dictamen_exportacion/{id_dictamen}', 'MostrarDictamenExportacion')->name('PDF-dictamen-exportacion');
    //Reexpedir
    Route::post('/registrar/reexpedir', 'reexpedir')->name('dic-expor.reex');
});

//-------------------CERTIFICADO INSTALACIONES-------------------
Route::middleware(['auth'])->controller(Certificado_InstalacionesController::class)->group(function () {
    Route::get('certificados/instalaciones', [Certificado_InstalacionesController::class, 'UserManagement'])->name('certificados-instalaciones');
    Route::resource('certificados-list',Certificado_InstalacionesController::class);
    Route::post('certificados-list', [Certificado_InstalacionesController::class, 'store'])->name('certificados.store');
    Route::get('certificados-list/{id}/edit', [Certificado_InstalacionesController::class, 'edit']);
    Route::post('certificados-list/{id}', [Certificado_InstalacionesController::class, 'update']);
    Route::get('/ruta-para-obtener-revisores', [Certificado_InstalacionesController::class, 'obtenerRevisores']);
    Route::post('/asignar-revisor', [Certificado_InstalacionesController::class, 'storeRevisor'])->name('asignarRevisor'); //Agregar
    Route::post('/certificados/reexpedir', [Certificado_InstalacionesController::class, 'reexpedir'])->name('certificados.reexpedir');
    //Pdfs de certificados instalaciones
    Route::get('/certificado_comercializador/{id_certificado}', [Certificado_InstalacionesController::class, 'pdf_certificado_comercializador'])->name('certificado_comercializador');
    Route::get('/certificado_envasador_mezcal/{id_certificado}', [Certificado_InstalacionesController::class, 'pdf_certificado_envasador'])->name('certificado_envasador_mezcal');
    Route::get('/certificado_productor_mezcal/{id_certificado}', [Certificado_InstalacionesController::class, 'pdf_certificado_productor'])->name('certificado_productor_mezcal');

    Route::post('/certificados/instalacion/documento', [Certificado_InstalacionesController::class, 'subirCertificado']);
    Route::get('/certificados/instalacion/documento/{id}', [Certificado_InstalacionesController::class, 'CertificadoFirmado']);

/*         Route::get('/certificado-sin-marca-ins/{id}', function($id) {
        return app(Certificado_InstalacionesController::class)->pdf_certificado_productor($id, false);
        })->name('PDF-cer-insta-sin-marca');
 */

        Route::get('/certificado_productor_mezcal_sin_marca/{id}', function ($id) {
        return app(Certificado_InstalacionesController::class)->pdf_certificado_productor($id, false);
      })->name('certificado_productor_sin_marca');

      Route::get('/certificado_envasador_mezcal_sin_marca/{id}', function ($id) {
          return app(Certificado_InstalacionesController::class)->pdf_certificado_envasador($id, false);
      })->name('certificado_envasador_sin_marca');

      Route::get('/certificado_comercializador_sin_marca/{id}', function ($id) {
          return app(Certificado_InstalacionesController::class)->pdf_certificado_comercializador($id, false);
      })->name('certificado_comercializador_sin_marca');


});


//-------------------CERTIFICADO GRANEL-------------------
Route::middleware(['auth'])->controller(Certificado_GranelController::class)->group(function () {
    Route::get('certificados/granel', [Certificado_GranelController::class, 'UserManagement'])->name('certificados-granel');
    Route::resource('certificados/granel-list',Certificado_GranelController::class);
    Route::post('/certificados/granel', [Certificado_GranelController::class, 'store']);
    Route::get('/edit-certificados/granel/{id_certificado}', [Certificado_GranelController::class, 'edit']);
    Route::delete('/certificados/granel/{id_certificado}', [Certificado_GranelController::class, 'destroy'])->name('certificados.destroy');
    Route::get('/Pre-certificado-granel/{id}', [Certificado_GranelController::class, 'CertificadoGranel'])->name('PDF-cer-granel');
    //Descarga sin marca de agua (botón dinámico)
    Route::get('/certificado-sin-marca/{id}', function($id) {
        return app(Certificado_GranelController::class)->CertificadoGranel($id, false);
        })->name('PDF-cer-granel-sin-marca');
    Route::put('/certificados/granel/{id_certificado}', [Certificado_GranelController::class, 'update']);
    Route::post('/asignar-revisor/granel', [Certificado_GranelController::class, 'storeRevisor'])->name('asignarRevisor');
    Route::post('/granel/reexpedir', [Certificado_GranelController::class, 'reexpedir'])->name('cer-granel.reex');

    Route::post('/certificados/granel/documento', [Certificado_GranelController::class, 'subirCertificado']);
    Route::get('/certificados/granel/documento/{id}', [Certificado_GranelController::class, 'CertificadoFirmado']);
});

//-------------------CERTIFICADO EXPORTACION-------------------
Route::middleware(['auth'])->controller(Certificado_ExportacionController::class)->group(function () {
    //Mostrar
    Route::get('certificados/exportacion', 'UserManagement')->name('certificados-exportacion');
    Route::resource('CerExpo-list', Certificado_ExportacionController::class);
    //Registrar
    Route::post('creaCerExp', 'store')->name('cer-expor.registrar');
    ///Eliminar
    Route::delete('deletCerExp/{id_certificado}',  'destroy')->name('cer-expor.eliminar');
    ///Obtener Editar
    Route::get('editCerExp/{id_certificado}/edit', 'edit')->name('cer-expor.editar');
    ///Editar
    Route::put('editCerExp/{id_certificado}', 'update')->name('cer-expor.actualizar');
    // Ruta PDF con ID
    Route::get('/certificado_exportacion/{id_certificado}', 'MostrarCertificadoExportacion')->name('PDF-cer-exportacion');
    // Ruta PDF Solicitud-certificado
    Route::get('/solicitud_certificado_exportacion/{id_certificado}', 'MostrarSolicitudCertificadoExportacion')->name('PDF-SOL-cer-exportacion');
    //Reexpedir
    Route::post('/creaCerExp/reexpedir', [Certificado_ExportacionController::class, 'reexpedir'])->name('cer-expor.reex');
    //Asignar revisor
    Route::post('asignar_revisor_exportacion', [Certificado_ExportacionController::class, 'storeRevisor'])->name('cer-expor.asignarRevisor');
    Route::get('/certificados/exportar', 'exportar')->name('certificados.exportar');

    //documentacion
    Route::get('/documentos/{id_certificado}', 'documentos')->name('documentos-cer-exportacion');

    //visto bueno
    Route::get('/certificados/{id}/vobo', 'obtenerVobo');
    Route::post('/certificados/guardar-vobo', 'guardarVobo');

    //subir certificado firmado
    Route::post('/certificados/exportacion/documento', [Certificado_ExportacionController::class, 'subirCertificado']);
    Route::get('/certificados/exportacion/documento/{id}', [Certificado_ExportacionController::class, 'CertificadoFirmado']);

    //Obtener N° de lotes para hologramas en certificado
    Route::get('/certificados/contar-lotes/{id}', [Certificado_ExportacionController::class, 'contarLotes']);

});

//-------------------CERTIFICADO VENTA NACIONAL-------------------
Route::middleware(['auth'])->controller(Certificado_NacionalController::class)->group(function () {
    Route::get('certificados/venta_nacional', 'UserManagement')->name('certificados-nacional');
    Route::resource('CerVentaNacional-list', Certificado_NacionalController::class);
    Route::post('crear', 'store')->name('registrar-cer-nac');
    Route::delete('eliminar/{id_certificado}',  'destroy')->name('eliminar-cer-nac');
    Route::get('editar/{id_certificado}/edit', 'edit')->name('obtener-cer-nac');
    Route::put('actualizar/{id_certificado}', 'update')->name('actualizar-cer-nac');
    Route::get('/certificado_venta_nacional/{id}', 'certificado')->name('PDF-cer-nac');

    //Reexpedir
    Route::post('reexpedir', 'reexpedir')->name('reexpedir-cer-nac');
    //Asignar revisor
    Route::post('asignar_revisor_nacional', 'storeRevisor')->name('asignarRevisor-cer-nac');
});

//-------------------TRAMITE IMPI-------------------
Route::middleware(['auth'])->controller(impiController::class)->group(function () {
    Route::get('tramiteIMPI', [impiController::class, 'UserManagement'])->name('IMPI');
    Route::resource('tramite-list', impiController::class);
    Route::post('registrarImpi', [impiController::class, 'store'])->name('tramite-create');
    ///eliminar
    Route::delete('eliminar/{id_impi}', [impiController::class, 'destroy'])->name('instalacion.delete');
    ///obtener el editar
    Route::get('insta2/{id_impi}/edit', [impiController::class, 'edit'])->name('instalacion.edit');
    ///editar
    Route::put('insta2/{id_impi}', [impiController::class, 'update'])->name('tipos.update');

    //Registrar evento
    Route::post('crearEvento', [impiController::class, 'store'])->name('evento-create');
});

//-------------------RESUMEN DE INFORMACION DEL CLIENTE-------------------
Route::middleware(['auth'])->controller(resumenController::class)->group(function () {
    Route::get('resumen-datos', 'UserManagement')->name('resumen');
    Route::get('/get-datos-empresa/{id_empresa}', [resumenController::class, 'DatosEmpresa']);
});

Route::middleware(['auth'])->controller(firmaController::class)->group(function () {
    Route::get('firmarCadena', 'firmarCadena')->name('firmarCadena');
});
