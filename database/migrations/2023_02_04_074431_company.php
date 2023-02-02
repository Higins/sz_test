<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->integer("id")->autoIncrement();
            $table->string("companyName");
            $table->string("companyRegistrationNumber"); 
            $table->date("companyFoundationDate"); 
            $table->string("country");         
            $table->string("zipCode"); 
            $table->string("city"); 
            $table->string("streetAddress");
            $table->float("lat");
            $table->float("long");
            $table->string("companyOwner");
            $table->integer("employees");
            $table->string("activity");
            $table->boolean("active");
            $table->string("email");
            $table->string("password");
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('companies');
    }
};
