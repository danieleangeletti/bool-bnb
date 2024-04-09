# Passi da fare per poter utilizzare il template di Laravel

0. Creo la repository a partire dal template e mi clono la repository appena creata

1. Copio il file .env.example e lo rinomino in .env

2. Apro il terminale ed eseguo il comando composer install

3. Sempre nel terminale, al termine del comando composer install, eseguo il comando php artisan key:generate

4. Sempre nel terminale, al termine dell'esecuzione di php artisan key:generate, eseguiamo il comando npm install (oppure, npm i)

5. Sempre nel terminale, al termine di npm install, eseguire il comando npm run build
- Al posto di npm run build, potreste eseguire npm run dev e lasciarlo attivo

6. Aprire un altro terminale ed eseguire il comando php artisan serve


--------------------------------------------------------------------------------------------


# Passi per creare un'architettura CRUD completa

1. Inseriamo i parametri corretti nel file .env per connetterci al database di interesse

2. Creiamo la migration relativa alla risorsa. Il nome della migration sarà: create_NOME_RISORSA_IN_INGLESE_IN_SNAKE_CASE_AL_PLURALE_table (ad es., se la risorsa è libro, il nome della migration sarà create_books_table)

Una volta create tutte le migration necessarie (oppure per ogni migration), eseguire il comando php artisan migrate 

3. Creiamo il model relativo alla risorsa. Il nome del model sarà: NomeRisorsaInIngleseInPascalCaseAlSingolare (ad es., se la risorsa è libro, il nome del model sarà Book)

4. Creiamo il seeder relativo alla risorsa. Il nome del seeder sarà:
- NomeDellaTabellaDellaRisorsaInPascalCaseTableSeeder
- Oppure, NomeDelModelSeeder
(quindi, ad es., se la mia risorsa è libro, il nome del seeder sarà o BooksTableSeeder, oppure BookSeeder)

Una volta creati tutti i seeder necessari (oppure per ogni seeder), eseguire il comando php artisan db:seed --class=NomeSeeder per ogni seeder

OPPURE

Inserire in DatabaseSeeder la chiamata alla funzione $this->call(ARRAY), dove ARRAY sarà un array contenente tutti i riferimenti alle classi dei seeder da richiamare ed eseguire il comando php artisan db:seed

5. Creiamo il controller relativo alla risorsa. Il nome del controller sarà: NomeDelModelController (ad es., se la risorsa è libro, il nome del controller sarà BookController). Sarebbe ancora meglio creare il controller aggiungendo al comando il flag --resource, in modo da pre-popolare il controller con la definizione di tutte e 7 le funzioni che ci serviranno per le CRUD (cioè, il comando da eseguire sarà: php artisan make:controller NomeController --resource)

6. Definiamo le rotte relative alle funzioni del controller (quindi, 7 rotte). Sarebbe ancora meglio definirle tramite la chiamata al metodo resource di Route (cioè, se voglio definire le rotte relative alla risorsa libro, scriverò: Route::resource('books', BookController::class))

7. Creiamo le view relative alla risorsa. Nello specifico, dobbiamo creare 4 view:
- Una per l'index
- Una per lo show
- Una per il create
- Una per l'edit

Tutte queste 4 view, saranno messe in una cartella dentro views, nominata come la risorsa al plurale in kebab case (ad es., se la risorsa è mio libro, il nome della cartella sarà my-books). I nomi delle 4 view, solitamente, corrisponderanno al nome della funzione che le restituisce (quindi, index.blade.php per index, show.blade.php per show, create.blade.php per create e edit.blade.php per edit)

# Info utili
- Comando per tornare indietro di un batch di migration: php artisan migrate:rollback
- Comando per tornare indietro di tutti i batch di migration: php artisan migrate:reset
- Comando per eseguire migrate:reset + migrate: php artisan migrate:refresh
- Comando per eseguire migrate + db:seed: php artisan migrate --seed / php artisan migrate:refresh --seed
- Comando per vedere la lista delle rotte definite nell'applicazione: php artisan route:list
- Comando per creare un model, una migration, un seeder e un resource controller tutto insieme: php artisan make:model NomeRisorsa -msr




$allServices = [
            'Wifi' => '<i class="fa-solid fa-wifi"></i>',
            'Aria Condizionata' => '<i class="fa-solid fa-wind"></i>',
            'Piscina' => '<i class="fa-solid fa-water-ladder"></i>',
            'Spiaggia Privata' => '<i class="fa-solid fa-umbrella-beach"></i>',
            'Parcheggio' => '<i class="fa-solid fa-car"></i>',
            'Navetta' => '<i class="fa-solid fa-van-shuttle"></i>',
            'Lavanderia' => ' <i class="fa-solid fa-jug-detergent"></i>',
            'Fumatori' => ' <i class="fa-solid fa-smoking"></i>',
            'Animali Consentiti' => '<i class="fa-solid fa-paw"></i>',
        ];
        public function calculateEndDateAndExpireSponsorship($apartment_id, $sponsorship_id) {
    $apartment = Apartment::find($apartment_id);
    $sponsorship = $apartment->sponsorships()->where('id', $sponsorship_id)->first();

    if ($sponsorship) {
        // Calcola la data di fine aggiungendo le ore di durata alla data di creazione
        $endDate = Carbon::now()->addHours($sponsorship->hour_duration);

        // Aggiorna il campo end_date nella tabella pivot
        $apartment->sponsorships()->updateExistingPivot($sponsorship_id, ['end_date' => $endDate]);
        
        // Salva l'appartamento dopo l'aggiornamento
        $apartment->save();
        
        // Se la data di fine è passata, fai scadere la sponsorship
        if (Carbon::now()->greaterThanOrEqualTo($endDate)) {
            $apartment->sponsorships()->detach($sponsorship_id);
            // Puoi anche fare altre operazioni qui, come notificare l'utente
        }
    } else {
        // La sponsorship non è associata all'appartamento
        // Puoi gestire questo caso come preferisci, ad esempio emettere un avviso o un log
    }
}





public function handle()
{
    // Limita il numero di appartamenti elaborati per ogni esecuzione del comando
    $apartments = Apartment::take(100)->get();

    foreach ($apartments as $apartment) {
        $sponsorships = $apartment->sponsorships()->get();

        foreach ($sponsorships as $sponsorship) {
            $this->calculateEndDateAndExpireSponsorship($apartment->id, $sponsorship->id);
        }
    }
}
questa funzione serve per limitare le interazione con la cessazzione delle sponsorizzazioni e va messa nel file commands sponsorship expire
