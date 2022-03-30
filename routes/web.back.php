<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\TaxController;
use App\Http\Controllers\Admin\SaleController;
use App\Http\Controllers\Admin\UnitController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\ContactController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ReportsController;
use App\Http\Controllers\Admin\VariantController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CurrencyController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CustomOrderController;
use App\Http\Controllers\Admin\SmsSettignsController;
use App\Http\Controllers\Admin\StockReportController;
use App\Http\Controllers\Admin\SubcategoryController;
use App\Http\Controllers\Admin\CustomProductController;
use App\Http\Controllers\Admin\CustomServiceController;
use App\Http\Controllers\Admin\ManageCompanyController;
use App\Http\Controllers\Admin\ManageGatewayController;
use App\Http\Controllers\Admin\EmailConfigurationController;
use App\Http\Controllers\Admin\Custom\OurCustomServiceController;



// ------------ Frontend namespace ----------------------

use App\Http\Controllers\User\CartController;
use App\Http\Controllers\User\HomeController;
use App\Http\Controllers\User\ShopController;
use App\Http\Controllers\User\UserDashboardController;
use App\Http\Controllers\User\AboutController;

use App\Http\Controllers\User\GalleryController as CustomerGalleryController;
use App\Http\Controllers\User\OrderController as CustomerOrderController;
use App\Http\Controllers\User\ContactController as CustomerContactController;
use App\Http\Controllers\User\CustomOrderController as UserCustomOrderController;
// ------------ Frontend namespace ----------------------

Route::redirect('/', '/home', 301);
Route::redirect('/user/dashboard', '/dashboard', 301);
Route::redirect('/admin', '/admin/dashboard', 301);

// --------------------------- Frontend ---------------------------------

Route::group(['prefix' => ''], function () {
    // --------------------------- Generak Route goes Here ---------------------------------
    Route::get('/home',         [HomeController::class, 'index'])->name('index');
    Route::get('/shop',         [ShopController::class, 'index'])->name('shop_index');
    Route::get('/shop/{slug}',  [ShopController::class, 'show'])->name('product_detail');
    Route::get('/cart',         [CartController::class, 'index'])->name('cart_index');
    Route::get('/custom-order', [UserCustomOrderController::class, 'index'])->name('customorder_index');
    Route::get('/checkout',     [CustomerOrderController::class, 'index'])->name('checkout_index');
    Route::get('/contact',      [CustomerContactController::class, 'index'])->name('contact_index');
    Route::get('/about-us',     [AboutController::class, 'index'])->name('about_index');
    Route::get('/gallery',      [CustomerGalleryController::class, 'index'])->name('gallery_index');

    // --------------------------- Auth Route goes here ---------------------------------
    Route::group(['prefix' => 'dashboard', 'as' => 'dashboard.', 'middleware' => ['auth:web', 'PreventBackHistory']], function () {
        Route::get('/', [UserDashboardController::class, 'index'])->name('index');
    });
});


// --------------------------- Admin Dashboard ---------------------------------

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => ['auth:admin', 'PreventBackHistory']], function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/tables', function () {
        return view('backend.demo.table');
    });

    Route::get('/charts', function () {
        return view('backend.demo.chart');
    });

    Route::group(['prefix' => 'category', 'as' => 'category.'], function () {
        Route::get('/',             [CategoryController::class, 'index'])->name('index');
        Route::post('/',            [CategoryController::class, 'store'])->name('store');
        Route::put('/{category}',   [CategoryController::class, 'update'])->name('update');
        Route::delete('/{category}', [CategoryController::class, 'destroy'])->name('destroy');
    });

    Route::group(['prefix' => 'subcategory', 'as' => 'subcategory.'], function () {
        Route::get('/',             [SubcategoryController::class, 'index'])->name('index');
        Route::post('/',            [SubcategoryController::class, 'store'])->name('store');
        Route::put('/{subcategory}', [SubcategoryController::class, 'update'])->name('update');
        Route::delete('/{subcategory}', [SubcategoryController::class, 'destroy'])->name('destroy');
    });

    Route::group(['prefix' => 'brand', 'as' => 'brand.'], function () {
        Route::get('/',             [BrandController::class, 'index'])->name('index');
        Route::post('/',            [BrandController::class, 'store'])->name('store');
        Route::put('/{brand}',      [BrandController::class, 'update'])->name('update');
        Route::delete('/{brand}',   [BrandController::class, 'destroy'])->name('destroy');
    });

    Route::group(['prefix' => 'variants', 'as' => 'variant.'], function () {
        Route::get('/',             [VariantController::class, 'index'])->name('index');
        Route::post('/',            [VariantController::class, 'store'])->name('store');
        Route::put('/{variant}',    [VariantController::class, 'update'])->name('update');
        Route::delete('/{variant}', [VariantController::class, 'destroy'])->name('destroy');
    });

    Route::group(['prefix' => 'units', 'as' => 'unit.'], function () {
        Route::get('/',             [UnitController::class, 'index'])->name('index');
        Route::post('/',            [UnitController::class, 'store'])->name('store');
        Route::put('/{unit}',       [UnitController::class, 'update'])->name('update');
        Route::delete('/{unit}',    [UnitController::class, 'destroy'])->name('destroy');
    });

    Route::group(['prefix' => 'taxes', 'as' => 'tax.'], function () {
        Route::get('/',             [TaxController::class, 'index'])->name('index');
        Route::post('/',            [TaxController::class, 'store'])->name('store');
        Route::put('/{tax}',        [TaxController::class, 'update'])->name('update');
        Route::delete('/{tax}',     [TaxController::class, 'destroy'])->name('destroy');
    });

    Route::group(['prefix' => 'currencies', 'as' => 'currency.'], function () {
        Route::get('/',             [CurrencyController::class, 'index'])->name('index');
        Route::post('/',            [CurrencyController::class, 'store'])->name('store');
        Route::put('/{currency}',   [CurrencyController::class, 'update'])->name('update');
        Route::delete('/{currency}', [CurrencyController::class, 'destroy'])->name('destroy');
    });

    // Route::get('/currency', function () {
    //     return view('backend.pages.currency.currencylist');
    // })->name('currency');

    Route::get('/image-gallery', function () {
        return view('backend.pages.imagegallery.imagegallerylist');
    })->name('image-gallery');

    Route::get('/add-image-gallery', function () {
        return view('backend.pages.imagegallery.addgallery');
    })->name('add-image-gallery');

    Route::group(['prefix' => 'suppliers', 'as' => 'supplier.'], function () {
        Route::get('/',             [SupplierController::class, 'index'])->name('index');
        Route::post('/',            [SupplierController::class, 'store'])->name('store');
        Route::put('/{supplier}',   [SupplierController::class, 'update'])->name('update');
        Route::delete('/{supplier}', [SupplierController::class, 'destroy'])->name('destroy');
    });

    Route::group(['prefix' => 'customers', 'as' => 'customer.'], function () {
        Route::get('/',             [CustomerController::class, 'index'])->name('index');
        Route::post('/',            [CustomerController::class, 'store'])->name('store');
        Route::put('/{customer}',   [CustomerController::class, 'update'])->name('update');
        Route::delete('/{customer}', [CustomerController::class, 'destroy'])->name('destroy');
    });

    Route::get('/add-purchase', function () {
        return view('backend.pages.purchase.addpurchase');
    })->name('add-purchase');

    Route::get('/manage-purchase', function () {
        return view('backend.pages.purchase.managepurchase');
    })->name('manage-purchase');



    Route::group(['prefix' => 'products', 'as' => 'products.'], function () {
        Route::get('/',             [ProductController::class, 'index'])->name('index');
        Route::get('/create',       [ProductController::class, 'create'])->name('create');
        Route::post('/',            [ProductController::class, 'store'])->name('store');
        Route::put('/{product}',    [ProductController::class, 'update'])->name('update');
        Route::delete('/{product}', [ProductController::class, 'destroy'])->name('destroy');
    });

    // Route::get('/add-product', function () {
    //     return view('backend.pages.product.addproduct');
    // })->name('add_product');

    // Route::get('/manage-product', function () {
    //     return view('backend.pages.product.manageproduct');
    // })->name('manage_product');




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

    Route::get('/custom-service', [OurCustomServiceController::class, 'index'])->name('admin.custom_service');

    Route::group(['prefix' => 'customservices', 'as' => 'customservice.'], function () {
        Route::get('/',                     [OurCustomServiceController::class, 'index'])->name('index');
        Route::post('/',                    [OurCustomServiceController::class, 'store'])->name('store');
        Route::put('/{ourCustomService}',   [OurCustomServiceController::class, 'update'])->name('update');
        Route::delete('/{ourCustomService}', [OurCustomServiceController::class, 'destroy'])->name('destroy');
    });

    Route::group(['prefix' => 'contacts', 'as' => 'contact.'], function () {
        Route::get('/',             [ContactController::class, 'index'])->name('index');
        Route::post('/',            [ContactController::class, 'store'])->name('store');
        Route::put('/{contact}',    [ContactController::class, 'update'])->name('update');
        Route::delete('/{contact}', [ContactController::class, 'destroy'])->name('destroy');
    });

    // Route::get('/contact-us', [ContactController::class, 'index'])->name('contact_us');

});


require __DIR__ . '/auth.php';
