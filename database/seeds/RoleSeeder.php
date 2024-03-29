<?php

use Illuminate\Database\Seeder;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Create Role
        Sentinel::getRoleRepository()
            ->createModel()
            ->create([
                'name'       => 'Administrator',
                'slug'       => 'admin',
            ]);

        Sentinel::getRoleRepository()
            ->createModel()
            ->create([
                'name'       => 'Receptionist',
                'slug'       => 'receptionist',
            ]);

        Sentinel::getRoleRepository()
            ->createModel()
            ->create([
                'name'       => 'Therapist',
                'slug'       => 'therapist',
            ]);

        Sentinel::getRoleRepository()
            ->createModel()
            ->create([
                'name'       => 'Customer',
                'slug'       => 'customer',
            ]);

        // admin permission add
        $role_admin = Sentinel::findRoleBySlug('admin');
        $role_admin->permissions = [
            'api.create'=>true,
            'api.list'=>true,
            'api.delete'=>true,
            'api.update'=>true,
            'setting.edit'=>true,
            'profile.update' => true,
            'therapist.list' => true,
            'therapist.create' => true,
            'therapist.view' => true,
            'therapist.update' => true,
            'therapist.delete' => true,
            'therapist.time_edit' => true,
            'receptionist.list' => true,
            'receptionist.create' => true,
            'receptionist.update' => true,
            'receptionist.delete' => true,
            'receptionist.view' => true,
            'customer.list' => true,
            'customer.create' => true,
            'customer.update' => true,
            'customer.delete' => true,
            'customer.view' => true,
            'membership.list'=>true,
            'membership.create'=>true,
            'membership.update'=>true,
            'membership.delete'=>true,
            'customermember.list'=>true,
            'customermember.create'=>true,
            'customermember.update'=>true,
            'customermember.delete'=>true,
            'product.list'=>true,
            'product.create'=>true,
            'product.update'=>true,
            'product.delete'=>true,
            'room.list'=>true,
            'room.create'=>true,
            'room.update'=>true,
            'room.delete'=>true,
            'promo.list'=>true,
            'promo.show'=>true,
            'promo.create'=>true,
            'promo.update'=>true,
            'promo.delete'=>true,
            'transaction.list'=>true,
            'transaction.show'=>true,
            'transaction.create'=>true,
            'transaction.update'=>true,
            'transaction.delete'=>true,
            'invoice.show' => true,
            'invoice.list' => true,
            'invoice.create' => true,
            'invoice.update' => true,
            'invoice.delete' => true,
            'invoice.edit'=>true,
            'invoice.invoice_pdf'=>true,
            'invoice.review'=>true,
            'report.filter'=>true,
            'report.view'=>true,
        ];
        $role_admin->save();

        // receptionist permission add
        $role_receptionist = Sentinel::findRoleBySlug('receptionist');
        $role_receptionist->permissions = [
            'profile.update' => true,
            'therapist.list' => true,
            'therapist.view' => true,
            'customer.list' => true,
            'customer.create' => true,
            'customer.update' => true,
            'customer.delete' => true,
            'customer.view' => true,
            'customermember.list'=>true,
            'customermember.create'=>true,
            'customermember.update'=>true,
            'customermember.delete'=>true,
            'promo.list'=>true,
            'promo.show'=>true,
            'promo.create'=>true,
            'promo.update'=>true,
            'invoice.show' => true,
            'invoice.list' => true,
            'invoice.create' => true,
            'invoice.update' => true,
            'invoice.delete' => true,
            'invoice.edit'=>true,
            'invoice.invoice_pdf'=>true,
            'invoice.review'=>true,
            
        ];
        $role_receptionist->save();

        // therapist permission add
        $role_therapist = Sentinel::findRoleBySlug('therapist');
        $role_therapist->permissions = [
            'profile.update' => true,
            'invoice.show' => true,
        ];
        $role_therapist->save();

        // customer permission add
        $role_customer = Sentinel::findRoleBySlug('customer');
        $role_customer->permissions = [
            'profile.update' => true,
            'invoice.show' => true,
        ];
        $role_customer->save();
    }
}
