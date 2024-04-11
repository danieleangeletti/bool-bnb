<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Apartment;
use Carbon\Carbon;

class DestroyExpiredSponsorships extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sponsorships:destroy-expired';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Destroy expired sponsorships for all apartments';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Ottieni tutti gli appartamenti
        $apartments = Apartment::all();

        // Itera su ciascun appartamento
        foreach ($apartments as $apartment) {
            // Ottieni tutte le sponsorizzazioni scadute associate all'appartamento
            $expiredSponsorships = $apartment->sponsorships()
                ->wherePivot('end_date', '<', Carbon::now())
                ->get();

            // Elimina i collegamenti scaduti dalla tabella pivot
            foreach ($expiredSponsorships as $sponsorship) {
                $apartment->sponsorships()->detach($sponsorship->id);
            }
        }

        $this->info('Expired sponsorships have been destroyed successfully.');
    }
}

