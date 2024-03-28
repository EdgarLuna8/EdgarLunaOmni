<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('codigo')->unique();
            $table->string('nombre')->required();
            $table->integer('salarioDolares')->required();
            $table->integer('salarioPesos')->required();
            $table->string('direccion')->required();
            $table->string('estado')->required();
            $table->string('ciudad')->required();
            $table->string('celular')->required();
            $table->string('correo')->required()->unique();
            $table->boolean('activo')->required()->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
