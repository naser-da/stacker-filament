<?php

return [
    'pages' => [
        'dashboard' => [
            'title' => 'Dashboard',
        ],
    ],
    'resources' => [
        'customers' => [
            'label' => 'Customer',
            'plural_label' => 'Customers',
            'navigation_label' => 'Customers',
            'navigation_group' => 'Sales Management',
            'name' => 'Name',
            'email' => 'Email',
            'phone' => 'Phone',
            'address' => 'Address',
            'notes' => 'Notes',
            'delete_modal_title' => 'Delete Customer',
            'customer_information' => 'Customer Information',
            'sales_information' => 'Sales Information',
            'total_orders_amount' => 'Total Orders Amount',
            'last_order_date' => 'Last Order Date',
            'total_orders' => 'Total Orders',
            'recent_sales' => 'Recent Sales',
        ],
        'products' => [
            'label' => 'Product',
            'plural_label' => 'Products',
            'navigation_label' => 'Products',
            'navigation_group' => 'Inventory Management',
            'delete_modal_title' => 'Delete Product',
            'delete_modal_description' => 'Are you sure you want to delete this product? This action cannot be undone.',
        ],
        'sales' => [
            'label' => 'Sale',
            'plural_label' => 'Sales',
            'navigation_label' => 'Sales',
            'navigation_group' => 'Sales Management',
            'table_heading' => 'Sales',
            'list_title' => 'Sales',
            'create_button' => 'Add Sale',
            'edit_title' => 'Edit Sale',
            'edit_breadcrumb' => 'Edit',
            'delete_modal_title' => 'Delete Sale',
            'delete_modal_description' => 'Are you sure you want to delete this sale?',
            'delete_product_modal_title' => 'Remove Product',
            'delete_product_modal_description' => 'Are you sure you want to remove this product from the sale?',
            'customer' => 'Customer',
            'total_amount' => 'Total Amount',
            'delete_product_modal_submit' => 'Delete',
            'delete_product_modal_cancel' => 'Cancel',
            'products' => 'Products',
            'product' => 'Product',
            'quantity' => 'Quantity',
            'unit_price' => 'Unit Price',
            'total_amount' => 'Total Amount',
            'notes' => 'Notes',
            'items' => 'Items',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'subtotal' => 'Subtotal',
            'total' => 'Total',
            'table_heading' => 'Sales',
            'create_button' => 'Add Sale',
            'order_date' => 'Order Date',
            'view_title' => 'View Sale',
            'view_breadcrumb' => 'View',
        ],
        'categories' => [
            'label' => 'Category',
            'plural_label' => 'Categories',
            'navigation_label' => 'Categories',
            'navigation_group' => 'Inventory Management',
        ],
    ],
    'common' => [
        'actions' => [
            'create' => 'Create',
            'edit' => 'Edit',
            'delete' => 'Delete',
            'save' => 'Save',
            'cancel' => 'Cancel',
        ],
        'fields' => [
            'name' => 'Name',
            'email' => 'Email',
            'phone' => 'Phone',
            'price' => 'Price',
            'quantity' => 'Quantity',
            'total' => 'Total',
            'notes' => 'Notes',
            'address' => 'Address',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'language' => 'Language',
        ],
    ],
    'navigation' => [
        'dashboard' => 'Dashboard',
        'settings' => 'Settings',
    ],
    'widgets' => [
        'stats' => [
            'total_customers' => 'Total Customers',
            'total_products' => 'Total Products',
            'total_sales' => 'Total Sales',
            'total_revenue' => 'Total Revenue',
            'average_order' => 'Average Order',
        ],
        'sales_chart' => [
            'title' => 'Sales Over Time',
            'start_date' => 'Start Date',
            'end_date' => 'End Date',
        ],
    ],
];
