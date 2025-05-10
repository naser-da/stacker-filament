<?php

return [
    'pages' => [
        'dashboard' => [
            'title' => 'لوحة التحكم',
        ],
    ],
    'resources' => [
        'customers' => [
            'label' => 'العملاء',
            'plural_label' => 'العملاء',
            'navigation_label' => 'العملاء',
            'navigation_group' => 'إدارة المبيعات',
        ],
        'products' => [
            'label' => 'المنتجات',
            'plural_label' => 'المنتجات',
            'navigation_label' => 'المنتجات',
            'navigation_group' => 'إدارة المخزون',
        ],
        'sales' => [
            'label' => 'المبيعات',
            'plural_label' => 'المبيعات',
            'navigation_label' => 'المبيعات',
            'navigation_group' => 'إدارة المبيعات',
        ],
        'categories' => [
            'label' => 'الفئات',
            'plural_label' => 'الفئات',
            'navigation_label' => 'الفئات',
            'navigation_group' => 'إدارة المخزون',
        ],
    ],
    'common' => [
        'actions' => [
            'create' => 'إنشاء',
            'edit' => 'تعديل',
            'delete' => 'حذف',
            'save' => 'حفظ',
            'cancel' => 'إلغاء',
        ],
        'fields' => [
            'name' => 'الاسم',
            'email' => 'البريد الإلكتروني',
            'phone' => 'الهاتف',
            'price' => 'السعر',
            'quantity' => 'الكمية',
            'total' => 'المجموع',
            'notes' => 'ملاحظات',
            'created_at' => 'تاريخ الإنشاء',
            'updated_at' => 'تاريخ التحديث',
            'language' => 'اللغة',
        ],
    ],
    'navigation' => [
        'dashboard' => 'لوحة التحكم',
        'settings' => 'الإعدادات',
    ],
    'widgets' => [
        'stats' => [
            'total_customers' => 'إجمالي العملاء',
            'total_products' => 'إجمالي المنتجات',
            'total_sales' => 'إجمالي المبيعات',
            'total_revenue' => 'إجمالي الإيرادات',
            'average_order' => 'متوسط الطلب',
        ],
    ],
]; 