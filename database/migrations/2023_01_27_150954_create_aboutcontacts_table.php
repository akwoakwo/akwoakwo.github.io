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
        Schema::create('aboutcontacts', function (Blueprint $table) {
            $table->id();
            $table->string('alamat');
            $table->string('maps');
            $table->string('telepon');
            $table->string('telepon_rujukan');
            $table->string('email');
            $table->string('email_rujukan');
            $table->string('media_sosial');
            $table->string('medsos_rujukan');
            $table->text('iframe');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('aboutcontacts');
    }
};
