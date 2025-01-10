<?php

use App\Http\Controllers\Api\Admin\AdsController;
use App\Http\Controllers\Api\Admin\BrokerController;
use App\Http\Controllers\Api\Admin\CompundController;
use App\Http\Controllers\Api\Admin\ContractController;
use App\Http\Controllers\Api\Admin\DealsController;
use App\Http\Controllers\Api\Admin\DeveloperControlelr;
use App\Http\Controllers\Api\Admin\FilesController;
use App\Http\Controllers\Api\Admin\HomepageController;
use App\Http\Controllers\Api\Admin\LeadController;
use App\Http\Controllers\Api\Admin\MarketingAgencyController;
use App\Http\Controllers\Api\Admin\PaymentMethodController;
use App\Http\Controllers\Api\Admin\PaymentsController;
use App\Http\Controllers\Api\Admin\PlanController;
use App\Http\Controllers\Api\Admin\RequestsController;
use App\Http\Controllers\Api\Admin\SubscriptionController;
use App\Http\Controllers\Api\Admin\UnitController;
use App\Http\Controllers\Api\Admin\UserController;
use App\Http\Controllers\Api\Admin\UsesVedioController;
use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\User\CommissionController;
use App\Http\Controllers\Api\User\DeveloperController as UserDeveloperController;
use App\Http\Controllers\Api\User\HomePageController as UserHomePageController;
use App\Http\Controllers\Api\User\PyamentMethodsController;
use App\Http\Controllers\Api\User\RequestsController as UserRequestsController;
use App\Http\Controllers\Api\User\SendContractController;
use App\Http\Controllers\Api\User\TransactionDealController;
use Illuminate\Support\Facades\Route;


Route::post('/register',[AuthController::class, 'register']);
Route::post('/login',[AuthController::class, 'login']);



Route::middleware(['auth:sanctum', 'IsSuperAdmin',])->group(function () {

    Route::get('/admin/homepage',[HomepageController::class, 'homepage']);

    Route::post('/admin/logout',[AuthController::class, 'logout']);

    /////////////////////////////////// ADS ////////////////////////////////////////////////////

    Route::get('/admin/ads',[AdsController::class, 'getAds']);

    Route::post('/admin/ads/add',[AdsController::class, 'addAdds']);

    Route::delete('/admin/ads/delete/{id}',[AdsController::class, 'deleteAds']);

//////////////////////////////////// Users ////////////////////////////////////////////////////

    Route::get('/admin/users',[UserController::class, 'getUsers']);

    Route::delete('/admin/users/delete/{id}',[UserController::class, 'deleteuser']);

    Route::get('/admin/admins',[UserController::class, 'getAdmins']);

    Route::post('/admin/admins/add',[UserController::class, 'addAdmin']);

    Route::delete('/admin/admins/delete/{id}',[UserController::class, 'deleteadmin']);

///////////////////////////////////////////// Developer ///////////////////////////////////////

    Route::get('/admin/developers',[DeveloperControlelr::class, 'AllDevelopers']);

    Route::get('/admin/developer/{id}',[DeveloperControlelr::class, 'developer']);

    Route::post('/admin/developer/add',[DeveloperControlelr::class, 'addDeveloper']);

    Route::delete('/admin/developer/delete/{id}',[DeveloperControlelr::class, 'deleteDeveloper']);

    Route::put('/admin/developer/update/{id}',[DeveloperControlelr::class, 'updateDeveloper']);

//////////////////////////////////////////// Uptowns (units) ////////////////////////////////////////////////

    Route::get('/admin/units/{compound_id}',[UnitController::class, 'unitDeveloper']);

    Route::post('/admin/units/add/{compound_id}',[UnitController::class, 'addUptown']);

    Route::delete('/admin/units/delete/{id}',[UnitController::class, 'deleteUptown']);

    Route::put('/admin/units/update/{id}',[UnitController::class, 'updateUptown']);

    Route::delete('/admin/unit/image/delete/{id}',[UnitController::class, 'DeleteUptownImage']);

///////////////////////////////////////////////// Requests (Training) /////////////////////////////////////////

    Route::get('/admin/requests/training',[RequestsController::class, 'getTrainingRequests']);

    Route::put('/admin/request/training/accept/{id}',[RequestsController::class, 'acceptTrainer']);

///////////////////////////////////////////// Requests (Complaints) /////////////////////////////////////////

    Route::get('/admin/requests/complaints',[RequestsController::class, 'getComplaints']);

    Route::delete('/admin/complaint/close/{id}',[RequestsController::class, 'closeComplaint']);

/////////////////////////////////////////// Marketing Agency //////////////////////////////////////////////

    Route::get('/admin/marketing-agency',[MarketingAgencyController::class, 'getMarketingAgency']);

    Route::post('/admin/marketing-agency/add',[MarketingAgencyController::class, 'addMarketagency']);

    Route::delete('/admin/marketing-agency/delete/{id}',[MarketingAgencyController::class, 'deleteMarketingAgency']);

//////////////////////////////////////////// Compounds /////////////////////////////////////////////////////////

    Route::get('/admin/compounds',[CompundController::class, 'compounds']);

    Route::post('/admin/compound/add',[CompundController::class, 'addCompound']);

    Route::delete('/admin/compound/delete/{id}',[CompundController::class, 'deleteCompound']);

///////////////////////////////////////////// Plans /////////////////////////////////////////////////////////

    Route::get('/admin/plans',[PlanController::class, 'plans']);

    Route::post('/admin/plan/add',[PlanController::class, 'addplan']);

    Route::put('/admin/plan/update/{id}',[PlanController::class, 'updateplan']);

    Route::delete('/admin/plan/delete/{id}',[PlanController::class, 'deleteplan']);

/////////////////////////////////////////////// Subscribtion ///////////////////////////////////////////////////

    Route::get('/admin/subscribtion',[SubscriptionController::class, 'getSubscribers']);

    Route::delete('/admin/subscribtion/delete/{id}',[SubscriptionController::class, 'deleteSubscribers']);

///////////////////////////////////////////////// Payment Method /////////////////////////////////////////////////////

    Route::get('/admin/payment-methods',[PaymentMethodController::class, 'getPaymentMethods']);

    Route::post('/admin/payment-method/add',[PaymentMethodController::class, 'createPaymentMethod']);

    Route::delete('/admin/payment-method/delete/{id}',[PaymentMethodController::class, 'deletePaymentMethod']);

////////////////////////////////////////////////// Pyaments /////////////////////////////////////////////////////

    Route::post('/admin/payments/create-subscription',[PaymentsController::class, 'createSubscription']);

    Route::get('/admin/payments/pending-payments',[PaymentsController::class, 'getPendingPayments']);

    Route::get('/admin/payments/history-payments',[PaymentsController::class, 'historyPayment']);

    Route::put('/admin/payments/approve-payment/{payment_id}',[PaymentsController::class, 'approvePayment']);

/////////////////////////////////////////////////// Leads //////////////////////////////////////////////////////////////////

    Route::get('/admin/leads',[LeadController::class, 'getLeads']);

    Route::delete('/admin/lead/delete/{id}',[LeadController::class, 'deleteLead']);

    Route::post('/admin/lead/add',[LeadController::class, 'AddLead']);

    Route::get('/admin/lead/ids',[LeadController::class, 'getIDS']);

    ////////////////////////////////////////////// AASSIGN LEAD TO BROKER ////////////////////////////////////////////////

    Route::post('/admin/broker/add-leads/{id}',[BrokerController::class, 'addLeadtoBroker']);

///////////////////////////////////////////////// Deals /////////////////////////////////////////////////////////////////

    Route::get('/admin/broker/leads/{id}',[DealsController::class, 'getBrokerLeads']);

    Route::post('/admin/deals/make-deal',[DealsController::class, 'makeDeal']);

    Route::get('/admin/deals/Alldeals',[DealsController::class, 'getalldeals']);

    Route::put('/admin/deals/semidone-deal/{id}',[DealsController::class, 'semidonedeal']);

    Route::put('/admin/deals/accept-deal/{dealid}/{brokerId}/{developerId}/{unitId}/{leadid}/{compoundid}',[DealsController::class, 'approveDeal']);

    Route::get('/admin/deals/leadbrockers',[DealsController::class, 'getleadbrockers']);

    Route::put('/admin/deals/edit-period-days/{id}',[DealsController::class, 'editPeriodDays']);

    Route::put('/admin/deals/reject-deal/{id}',[DealsController::class, 'rejectdeal']);

///////////////////////////////////////////// Files /////////////////////////////////////////////////////////////////

    Route::get('/admin/files',[FilesController::class, 'getallFiles']);

    Route::post('/admin/file/upload',[FilesController::class, 'addFile']);

    Route::delete('/admin/file/delete/{id}',[FilesController::class, 'deleteFile']);

////////////////////////////////////////////// Contracts /////////////////////////////////////////////////////////////

    Route::get('/admin/contracts',[ContractController::class, 'getContracts']);

    Route::post('/admin/contract/add',[ContractController::class, 'createContract']);

    Route::delete('/admin/contract/delete/{id}',[ContractController::class, 'deleteContract']);

    Route::put('/admin/contract/approve/{id}/{user_id}',[ContractController::class, 'approveContract']);

////////////////////////////////////////////// How to use Vedios /////////////////////////////////////////////////////

    Route::get('/admin/how-to-use-vedios',[UsesVedioController::class, 'getVedios']);

    Route::post('/admin/how-to-use-vedio/upload',[UsesVedioController::class, 'uploadVideo']);

    Route::delete('/admin/how-to-use-vedio/delete/{id}',[UsesVedioController::class, 'deleteVideo']);

});







Route::middleware(['auth:sanctum', 'IsUser'])->group(function () {

        Route::get('/user/homepage',[UserHomePageController::class, 'homepage']);

        Route::delete('/user/logout',[AuthController::class, 'logout']);

        Route::get('/user/profile',[UserHomePageController::class, 'profile']);

//////////////////////////////////////////////// Developer /////////////////////////////////////////////////////////

    Route::get('/user/developers',[UserDeveloperController::class, 'GetDevloper']);

    Route::get('/user/compounds/{developer_id}',[UserDeveloperController::class, 'getCompounds']);

/////////////////////////////////////////////// Plans PyamentMehtods /////////////////////////////////////////////////////

    Route::get('/user/plans-payment-method',[PyamentMethodsController::class, 'PlansPaymentMethod']);

///////////////////////////////////////////////// Contracts /////////////////////////////////////////////////////////

    Route::get('/user/files',[SendContractController::class, 'getfiles']);

    Route::post('/user/send-contract',[SendContractController::class, 'sendContract']);

///////////////////////////////////////////////// Training Request /////////////////////////////////////////////////////////

    Route::post('/user/send-training-request',[UserRequestsController::class, 'sendTrainingRequest']);

///////////////////////////////////////////////// Complaint /////////////////////////////////////////////////////////

    Route::post('/user/send-complaint',[UserRequestsController::class, 'sendComplaint']);

///////////////////////////////////////////////// Transaction Deals /////////////////////////////////////////////////////////

    Route::post('/user/send-transaction-deal',[TransactionDealController::class, 'sendTransactionDeals']);

    Route::get('/user/getLeadsIds',[TransactionDealController::class, 'leadid']);

    Route::get('/user/getDeveloperIds',[TransactionDealController::class, 'developerid']);

    Route::get('/user/getSalesDeveloperIds/{developer_id}',[TransactionDealController::class, 'salesdeveloperid']);

    Route::get('/user/getCompoundIds/{developer_id}',[TransactionDealController::class, 'compoundid']);

    Route::get('/user/getUptownIds/{compound_id}',[TransactionDealController::class, 'uptownid']);

////////////////////////////////////////////////// Compounds Commission /////////////////////////////////////////////////////

    Route::get('/user/GetCompounds-Commission',[CommissionController::class, 'getAllCommission']);
    });
