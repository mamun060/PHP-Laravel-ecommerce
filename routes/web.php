<?php

use App\Http\Controllers\Admin\ContactController;
use App\Http\Controllers\Admin\CustomOrderController;
use App\Http\Controllers\Admin\CustomProductController;
use App\Http\Controllers\Admin\CustomServiceController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\EmailConfigurationController;
use App\Http\Controllers\Admin\ManageCompanyController;
use App\Http\Controllers\Admin\ManageGatewayController;
use App\Http\Controllers\Admin\ReportsController;
use App\Http\Controllers\Admin\SaleController;
use App\Http\Controllers\Admin\SmsSettignsController;
use App\Http\Controllers\Admin\SocialIconController;
use App\Http\Controllers\Admin\StockReportController;
use App\Http\Controllers\Admin\WebFooterController;

// Route::redirect('/', '/admin/dashboard', 301);
// Route::redirect('/admin', '/admin/dashboard', 301);

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware'=>['auth:admin', 'PreventBackHistory']], function () {
    
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/tables', function () {
        return view('backend.demo.table');
    });

    Route::get('/charts', function () {
        return view('backend.demo.chart');
    });

    Route::view('/category', 'backend.pages.category.categorylist')->name('category');

    Route::get('/add-category', function () {
        return view('backend.pages.category.addcategory');
    });

    Route::get('/subcategory', function () {
        return view('backend.pages.category.subcategory');
    })->name('subcategory');

    Route::get('/brand', function () {
        return view('backend.pages.brand.brandListing');
    })->name('brand');

    Route::get('/variant', function () {
        return view('backend.pages.variant.variantlist');
    })->name('variant');

    Route::get('/unit', function () {
        return view('backend.pages.unit.unitlist');
    })->name('unit');

    Route::get('/tax', function () {
        return view('backend.pages.tax.taxlist');
    })->name('tax');

    Route::get('/currency', function () {
        return view('backend.pages.currency.currencylist');
    })->name('currency');

    Route::get('/image-gallery', function () {
        return view('backend.pages.imagegallery.imagegallerylist');
    })->name('image-gallery');

    Route::get('/add-image-gallery', function () {
        return view('backend.pages.imagegallery.addgallery');
    })->name('add-image-gallery');

    Route::get('/manage-supplier', function () {
        return view('backend.pages.supplier.supplierlist');
    })->name('manage-supplier');

    Route::get('/manage-customer', function () {
        return view('backend.pages.customer.managecustomer');
    })->name('manage-customer');

    Route::get('/add-purchase', function () {
        return view('backend.pages.purchase.addpurchase');
    })->name('add-purchase');

    Route::get('/manage-purchase', function () {
        return view('backend.pages.purchase.managepurchase');
    })->name('manage-purchase');

    Route::get('/add-product', function () {
        return view('backend.pages.product.addproduct');
    })->name('add_product');

    Route::get('/manage-product', function () {
        return view('backend.pages.product.manageproduct');
    })->name('manage_product');

    Route::get('/order-add', function () {
        return view('backend.pages.order.orderadd');
    })->name('order_add');

    Route::get('/order-manage', function () {
        return view('backend.pages.order.ordermanage');
    })->name('order_manage');

    Route::get('/manage-sale', [SaleController::class, 'index'])->name('manage_sale');
    Route::get('/add-sale', [SaleController::class, 'create'])->name('add_sale');
    Route::get('/manage-custom-order', [CustomOrderController::class, 'index'])->name('manage_custom_order');
    Route::get('/add-custom-order', [CustomOrderController::class, 'create'])->name('add_custom_order');

    Route::get('/stock-report', [StockReportController::class, 'stockreport'])->name('stock_report');
    Route::get('/supplier-stock-report', [StockReportController::class, 'supplierstock'])->name('supplier_stock-report');
    Route::get('/product-stock-report', [StockReportController::class, 'productreport'])->name('product_stock_report');

    Route::get('/sales-report', [ReportsController::class, 'salesreport'])->name('sales_report');
    Route::get('/purchase-report', [ReportsController::class, 'purchasereport'])->name('purchase_report');
    Route::get('/product-tax-report', [ReportsController::class, 'producttaxreport'])->name('product_tax_report');
    Route::get('/invoice-tax-report', [ReportsController::class, 'invoicetaxreport'])->name('invoice_tax_report');

    Route::get('/sms-configuration', [SmsSettignsController::class, 'smsconfiguration'])->name('sms_configuration');
    Route::get('/sms-template', [SmsSettignsController::class, 'smstemplate'])->name('sms_template');
    Route::get('/email-configuration', [EmailConfigurationController::class, 'index'])->name('email_configuration');
    Route::get('/manage-compnay', [ManageCompanyController::class, 'index'])->name('manage_company');
    Route::get('/manage-gateway', [ManageGatewayController::class, 'index'])->name('manage_gateway');

    Route::get('/contact-us', [ContactController::class, 'index'])->name('contact_us');
    Route::get('/web-footer', [WebFooterController::class, 'index'])->name('web_footer');
    Route::get('/social-icon', [SocialIconController::class, 'index'])->name('social_icon');

    Route::get('/custom-product', [CustomProductController::class, 'index'])->name('custom_product');
    Route::get('/custom-service', [CustomServiceController::class, 'index'])->name('admin.custom_service');
    
});


require __DIR__.'/auth.php';
