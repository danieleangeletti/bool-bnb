<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Models
use App\Models\Apartment;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('apartments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null')->onUpdate('cascade');
            $table->string('name', 100);
            $table->string('type_of_accomodation', 100);
            $table->tinyInteger('mq')->unsigned()->nullable();
            $table->tinyInteger('n_guests')->unsigned();
            $table->tinyInteger('n_rooms')->unsigned();
            $table->tinyInteger('n_beds')->unsigned();
            $table->tinyInteger('n_baths')->unsigned();
            $table->float('price', 6, 2)->unsigned();
            $table->boolean('availability')->default(true);
            $table->string('latitude', 100)->nullable();
            $table->string('longitude', 100)->nullable();
            // $table->string('city',64);
            $table->string('slug', 100);
            $table->string('address', 100);
            // $table->string('free_form_address',64)->nullable();
            $table->date('deleted_at')->nullable()->default(null);
            $table->string('img_cover_path', 1000)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('apartments');
    }
};
