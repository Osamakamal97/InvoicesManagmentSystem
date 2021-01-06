<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            // main header contents
            'invoices',
            'invoices_index',
            'invoices_archives',
            'paid_invoices',
            'part_paid_invoices',
            'unpaid_invoices',
            'reports',
            'invoices_reports',
            'customers_reports',
            'users',
            'users_index',
            'roles_index',
            'settings',
            'sections_index',
            'products_index',
            // Invoices things
            'create_invoice',
            'edit_invoice',
            'delete_invoice',
            'invoice_details',
            'edit_invoice_payment_status',
            'archive_invoice',
            'unarchive_invoice',
            'edit_invoice_status',
            'print_invoice',
            'export_invoices_excel',
            'add_invoice_attachment',
            'view_invoice_attachment',
            'download_invoice_attachment',
            'delete_invoice_attachment',
            // Customer Reports things
            // '',
            // Invoice Report things
            // '',
            // Users
            'create_user',
            'edit_user',
            'delete_user',
            'give_user_role',
            // '',
            // Users permissions
            'create_role',
            'edit_role',
            'show_role',
            'delete_role',
            'view_role_permissions',
            // '',
            // Roles
            'role-list',
            'role-create',
            'role-edit',
            'role-delete',
            // Products
            'create_product',
            'edit_product',
            'delete_product',
            // Sections
            'create_section',
            'edit_section',
            'delete_section',
            // '',
        ];
        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }
    }
}
