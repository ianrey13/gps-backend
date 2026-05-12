<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('locations', function (Blueprint $table) {
            $table->id();
            $table->string('device_id', 100);
            $table->decimal('latitude', 10, 8);
            $table->decimal('longitude', 11, 8);
            $table->float('accuracy')->nullable();
            $table->float('speed')->nullable();
            $table->integer('battery_level')->nullable();
            $table->dateTime('timestamp');
            $table->timestamps();
            
            $table->index('device_id');
            $table->index('timestamp');
        });
        
        Schema::create('devices', function (Blueprint $table) {
            $table->id();
            $table->string('device_name', 100);
            $table->string('device_token', 255)->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('devices');
        Schema::dropIfExists('locations');
    }
};