<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\FuelType;
use App\Models\AdvertisementType;
use App\Models\VehicleModel;
use App\Models\Equipment;
use App\Models\VehicleBody;
use App\Models\VehicleColor;
use App\Models\BlogCategory;
use App\Models\Faq;
use App\Models\AboutUs;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PopulateAllItalianTranslationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Starting comprehensive Italian translations population...');
        
        // Brands, Fuel Types, Advertisement Types
        $this->seedFuelTypes();
        $this->seedAdvertisementTypes();
        $this->seedBrands();
        $this->seedVehicleModels();
        
        // Equipment, Colors, Bodies, Blog Categories
        $this->seedVehicleBodies();
        $this->seedVehicleColors();
        $this->seedEquipment();
        $this->seedBlogCategories();
        
        // FAQ and About Us
        $this->seedFaqs();
        $this->seedAboutUs();
        
        $this->command->info('✓ All Italian translations completed successfully!');
    }

    /**
     * Seed fuel types Italian translations
     */
    private function seedFuelTypes(): void
    {
        $translations = [
            'Petrol' => 'Benzina',
            'Diesel' => 'Diesel',
            'Electric' => 'Elettrico',
            'Hybrid (Petrol/Electric)' => 'Ibrido (Benzina/Elettrico)',
            'LPG (Liquefied Petroleum Gas)' => 'GPL (Gas di Petrolio Liquefatto)',
            'CNG (Compressed Natural Gas)' => 'Metano',
            'Ethanol/E85' => 'Etanolo/E85',
            'Hydrogen' => 'Idrogeno',
            '2-Stroke Petrol' => 'Benzina 2 Tempi',
            '4-Stroke Petrol' => 'Benzina 4 Tempi',
            'Manual (Pedal Power)' => 'Manuale (Pedali)',
            'Pedelec (Pedal Assist)' => 'Pedelec (Assistenza Pedali)',
            'Speed E-Bike (S-Pedelec)' => 'Speed E-Bike (S-Pedelec)',
            'Electric Hybrid' => 'Ibrido Elettrico',
            'Other' => 'Altro',
        ];

        foreach ($translations as $english => $italian) {
            FuelType::where('name', $english)
                ->update(['name_it' => $italian]);
        }

        $this->command->info('✓ Fuel types translated');
    }

    /**
     * Seed advertisement types Italian translations
     */
    private function seedAdvertisementTypes(): void
    {
        $translations = [
            'Motorcycle' => 'Moto',
            'Motor Scooter' => 'Scooter',
            'Scooter' => 'Motorino',
            'Bike' => 'Bicicletta',
        ];

        foreach ($translations as $english => $italian) {
            AdvertisementType::where('title', $english)
                ->update(['title_it' => $italian]);
        }

        $this->command->info('✓ Advertisement types translated');
    }

    /**
     * Seed brands Italian translations
     */
    private function seedBrands(): void
    {
        $brands = Brand::all();
        
        $italianBrandNames = [
            // Motorcycle brands (usually stay the same)
            'Yamaha' => 'Yamaha',
            'Honda' => 'Honda',
            'Suzuki' => 'Suzuki',
            'Kawasaki' => 'Kawasaki',
            'BMW' => 'BMW',
            'Aprilia' => 'Aprilia',
            'Piaggio' => 'Piaggio',
            'Vespa' => 'Vespa',
            'Kymco' => 'Kymco',
            'SYM' => 'SYM',
            'KTM' => 'KTM',
            'Peugeot' => 'Peugeot',
            'Gilera' => 'Gilera',
            'MBK' => 'MBK',
            'Malaguti' => 'Malaguti',
            'Benelli' => 'Benelli',
            'Ducati' => 'Ducati',
            'Harley-Davidson' => 'Harley-Davidson',
            'Moto Guzzi' => 'Moto Guzzi',
            'MV Agusta' => 'MV Agusta',
            'Triumph' => 'Triumph',
            'Royal Enfield' => 'Royal Enfield',
            'Indian Motorcycle' => 'Indian',
            'Other' => 'Altro',
            
            // Bicycle brands
            'Trek' => 'Trek',
            'Giant' => 'Giant',
            'Specialized' => 'Specialized',
            'Cannondale' => 'Cannondale',
            'Scott' => 'Scott',
            'Cube' => 'Cube',
            'Orbea' => 'Orbea',
            'Bianchi' => 'Bianchi',
            'Colnago' => 'Colnago',
            'Pinarello' => 'Pinarello',
            'Wilier' => 'Wilier',
            'Merida' => 'Merida',
        ];
        
        foreach ($brands as $brand) {
            $englishName = $brand->name;
            
            if (isset($italianBrandNames[$englishName])) {
                $brand->update(['name_it' => $italianBrandNames[$englishName]]);
            } else {
                // Default: keep the same name
                $brand->update(['name_it' => $englishName]);
            }
        }

        $updated = Brand::whereNotNull('name_it')->count();
        $this->command->info("✓ {$updated} brands translated");
    }

    /**
     * Seed vehicle models Italian translations
     * Vehicle models usually keep their original names
     */
    private function seedVehicleModels(): void
    {
        $vehicleModels = VehicleModel::all();
        
        foreach ($vehicleModels as $model) {
            $englishName = $model->name;
            // Keep the same name as Italian (model names are usually international)
            $model->update(['name_it' => $englishName]);
        }

        $updated = VehicleModel::whereNotNull('name_it')->count();
        $this->command->info("✓ {$updated} vehicle models translated");
    }

    /**
     * Seed vehicle bodies Italian translations
     */
    private function seedVehicleBodies(): void
    {
        $translations = [
            'Naked' => 'Naked',
            'Sport' => 'Sportiva',
            'Touring' => 'Touristica',
            'Adventure' => 'Avventura',
            'Cruiser' => 'Cruiser',
            'Touring/Cruiser' => 'Tourismo/Cruiser',
            'On/Off Road' => 'On/Off Road',
            'Enduro' => 'Enduro',
            'Super Motard' => 'Super Motard',
            'Trial' => 'Trial',
            'Cross' => 'Cross',
            'Speedway' => 'Speedway',
            'Cafe Racer' => 'Cafe Racer',
            'Classic' => 'Classica',
            'Scooter' => 'Scooter',
            'Maxi-Scooter' => 'Maxi-Scooter',
            'Tourer' => 'Tourer',
            'Long-Range Tourer' => 'Gran Turismo',
            'Street' => 'Stradale',
            'City' => 'Città',
            'Road' => 'Stradale',
            'Mountain' => 'Mountain',
            'City/City Trekking' => 'Città/City Trekking',
            'Road/Touring' => 'Strada/Touristica',
            'Electric' => 'Elettrica',
            'Folding' => 'Pieghevole',
            'Hybrid' => 'Ibrida',
            'Cross-Country' => 'Cross-Country',
            'Downhill' => 'Downhill',
            'BMX' => 'BMX',
            'E-MTB' => 'E-MTB',
            'Tandem' => 'Tandem',
        ];

        foreach ($translations as $english => $italian) {
            VehicleBody::where('name', $english)
                ->update(['name_it' => $italian]);
        }

        // For any remaining, copy English name
        $vehicleBodies = VehicleBody::whereNull('name_it')->get();
        foreach ($vehicleBodies as $body) {
            $body->update(['name_it' => $body->name]);
        }

        $this->command->info('✓ Vehicle bodies translated');
    }

    /**
     * Seed vehicle colors Italian translations
     */
    private function seedVehicleColors(): void
    {
        $translations = [
            'Red' => 'Rosso',
            'White' => 'Bianco',
            'Black' => 'Nero',
            'Silver' => 'Argento',
            'Grey' => 'Grigio',
            'Blue' => 'Blu',
            'Green' => 'Verde',
            'Yellow' => 'Giallo',
            'Orange' => 'Arancione',
            'Brown' => 'Marrone',
            'Gold' => 'Oro',
            'Purple' => 'Viola',
            'Pink' => 'Rosa',
            'Beige' => 'Beige',
            'Navy' => 'Blu Scuro',
            'Turquoise' => 'Turchese',
            'Lime' => 'Lime',
            'Olive' => 'Oliva',
            'Cyan' => 'Ciano',
            'Magenta' => 'Magenta',
            'Indigo' => 'Indaco',
        ];

        foreach ($translations as $english => $italian) {
            VehicleColor::where('name', $english)
                ->update(['name_it' => $italian]);
        }

        // For any remaining, copy English name
        $vehicleColors = VehicleColor::whereNull('name_it')->get();
        foreach ($vehicleColors as $color) {
            $color->update(['name_it' => $color->name]);
        }

        $this->command->info('✓ Vehicle colors translated');
    }

    /**
     * Seed equipment Italian translations
     */
    private function seedEquipment(): void
    {
        $translations = [
            // Motorcycle equipment
            'ABS' => 'ABS',
            'LED Lights' => 'Luci LED',
            'Navigation System' => 'Sistema di Navigazione',
            'Heated Handles' => 'Manubrio Riscaldo',
            'Reverse Gear' => 'Marcia Indietro',
            'Traction Control' => 'Controllo Trazione',
            'Parking Sensors' => 'Sensori di Parcheggio',
            'USB Charger' => 'Caricatore USB',
            'Radio' => 'Autoradio',
            'TPMS (Tire Pressure Monitoring)' => 'TPMS (Monitoraggio Pressione)',
            'Saddlebags' => 'Borse Laterali',
            'Top Case' => 'Bauletto',
            'Windshield' => 'Parabrezza',
            'Crash Bars' => 'Barre di Protezione',
            'Airbag Vest' => 'Giubbotto Airbag',
            'GPS' => 'GPS',
            'Smartphone Mount' => 'Supporto Smartphone',
            'Fog Lights' => 'Fari Nebbia',
            'Alarm System' => 'Sistema Antifurto',
            'Immobilizer' => 'Immobilizzatore',
            // Bicycle equipment
            'Electric Assist' => 'Assistenza Elettrica',
            'Lights' => 'Luci',
            'Bell' => 'Campanello',
            'Water Bottle Holder' => 'Porta Borraccia',
            'Kickstand' => 'Cavalletto',
            'Fenders' => 'Parafanghi',
            'Rear Rack' => 'Portapacchi Posteriore',
            'Basket' => 'Cestino',
            'Chain Guard' => 'Protezione Catena',
            'Suspension Fork' => 'Forcella Ammortizzata',
            'Disc Brakes' => 'Freni a Disco',
            'Multiple Gears' => 'Più Rapporti',
        ];

        foreach ($translations as $english => $italian) {
            Equipment::where('name', $english)
                ->update(['name_it' => $italian]);
        }

        // For any remaining, copy English name
        $equipments = Equipment::whereNull('name_it')->get();
        foreach ($equipments as $equipment) {
            $equipment->update(['name_it' => $equipment->name]);
        }

        $this->command->info('✓ Equipment translated');
    }

    /**
     * Seed blog categories Italian translations
     */
    private function seedBlogCategories(): void
    {
        $translations = [
            'News' => 'Notizie',
            'Buying Guide' => 'Guida all\'Acquisto',
            'Selling Guide' => 'Guida alla Vendita',
            'Maintenance' => 'Manutenzione',
            'Reviews' => 'Recensioni',
            'Tips & Tricks' => 'Consigli e Trucchi',
            'Safety' => 'Sicurezza',
            'Accessories' => 'Accessori',
            'Technology' => 'Tecnologia',
            'Events' => 'Eventi',
            'Industry News' => 'Notizie del Settore',
        ];

        foreach ($translations as $english => $italian) {
            BlogCategory::where('title', $english)
                ->update(['title_it' => $italian]);
        }

        // For any remaining, copy English title
        $blogCategories = BlogCategory::whereNull('title_it')->get();
        foreach ($blogCategories as $category) {
            $category->update(['title_it' => $category->title]);
        }

        $this->command->info('✓ Blog categories translated');
    }

    /**
     * Seed FAQs Italian translations
     */
    private function seedFaqs(): void
    {
        $faqTranslations = [
            // Buying
            'How do I search for vehicles on Wizmoto?' => [
                'question' => 'Come cerco veicoli su Wizmoto?',
                'answer' => 'Usa i nostri filtri di ricerca avanzati per trovare veicoli per tipo, marca, modello, fascia di prezzo, località e altro. Puoi anche sfogliare per categorie o usare la barra di ricerca rapida.'
            ],
            'How do I contact a seller?' => [
                'question' => 'Come contatto un venditore?',
                'answer' => 'Clicca il pulsante "Invia Messaggio" su qualsiasi annuncio per contattare direttamente il venditore. Puoi porre domande, richiedere più foto o organizzare una visita.'
            ],
            'Are the vehicles inspected?' => [
                'question' => 'I veicoli sono ispezionati?',
                'answer' => 'Anche se incoraggiamo annunci dettagliati, l\'ispezione dei veicoli è responsabilità degli acquirenti. Raccomandiamo di vedere e testare qualsiasi veicolo prima dell\'acquisto.'
            ],
            'What payment methods are accepted?' => [
                'question' => 'Quali metodi di pagamento sono accettati?',
                'answer' => 'I metodi di pagamento variano a seconda del venditore. La maggior parte accetta contanti, bonifici bancari o opzioni di finanziamento. Verifica sempre i termini di pagamento con il venditore prima di procedere.'
            ],
            // Selling
            'How do I list my vehicle for sale?' => [
                'question' => 'Come inserisco il mio veicolo in vendita?',
                'answer' => 'Crea un account concessionario, completa il tuo profilo e usa la funzione "Crea Annuncio" per elencare il tuo veicolo con foto, descrizione e specifiche.'
            ],
            'How much does it cost to list a vehicle?' => [
                'question' => 'Quanto costa inserire un veicolo?',
                'answer' => 'Le inserzioni base sono gratuite per i concessionari registrati. Le funzionalità premium e gli annunci promossi possono avere costi aggiuntivi. Controlla la nostra pagina prezzi per le tariffe attuali.'
            ],
            'How do I manage my listings?' => [
                'question' => 'Come gestisco i miei annunci?',
                'answer' => 'Accedi alla tua dashboard del concessionario per visualizzare, modificare, promuovere o rimuovere i tuoi annunci. Puoi anche tenere traccia delle richieste e gestire le informazioni del tuo profilo.'
            ],
            'Can I edit my listing after publishing?' => [
                'question' => 'Posso modificare il mio annuncio dopo la pubblicazione?',
                'answer' => 'Sì, puoi modificare i tuoi annunci in qualsiasi momento tramite la dashboard del concessionario. Aggiorna prezzi, descrizioni, foto o altri dettagli secondo necessità.'
            ],
            // General
            'Is Wizmoto free to use?' => [
                'question' => 'Wizmoto è gratuito?',
                'answer' => 'Sì, navigare e le funzionalità base sono completamente gratuite. Anche creare un account concessionario e gli annunci base sono gratuiti. Le funzionalità premium potrebbero avere costi.'
            ],
            'How do I create an account?' => [
                'question' => 'Come creo un account?',
                'answer' => 'Clicca "Registrati" per creare un account concessionario. Compila le informazioni del tuo business, verifica la tua email e inizia subito a elencare i tuoi veicoli.'
            ],
            'Is my personal information safe?' => [
                'question' => 'Le mie informazioni personali sono al sicuro?',
                'answer' => 'Sì, prendiamo sul serio la privacy. Le tue informazioni personali sono protette e non condivise mai senza il tuo consenso. Leggi la nostra Informativa sulla Privacy per i dettagli.'
            ],
            'How do I report a problem?' => [
                'question' => 'Come segnalo un problema?',
                'answer' => 'Contatta il nostro team di supporto tramite il modulo di contatto, inviaci una email direttamente o usa la funzione "Segnala" sugli annunci. Rispondiamo a tutte le richieste prontamente.'
            ],
        ];

        foreach ($faqTranslations as $englishQuestion => $translation) {
            Faq::where('question', $englishQuestion)
                ->update([
                    'question_it' => $translation['question'],
                    'answer_it' => $translation['answer']
                ]);
        }

        $this->command->info('✓ FAQ translations completed');
    }

    /**
     * Seed About Us Italian translations
     */
    private function seedAboutUs(): void
    {
        $aboutTranslations = [
            [
                'section' => 'mission',
                'title' => 'La Nostra Missione',
                'content' => 'In Wizmoto, la nostra missione è collegare gli appassionati di motociclette, scooter e biciclette con il loro veicolo perfetto. Forniamo un marketplace affidabile dove acquirenti e venditori possono connettersi in modo sicuro ed efficiente.'
            ],
            [
                'section' => 'story',
                'title' => 'La Nostra Storia',
                'content' => 'Fondato nel 2024, Wizmoto è nato da una passione per i veicoli a due ruote e dalla necessità di un marketplace affidabile e facile da usare. Il nostro team di appassionati di automobili ha capito le sfide affrontate sia dagli acquirenti che dai venditori nel mercato dei veicoli.'
            ],
            [
                'section' => 'why-choose',
                'title' => 'Perché Scegliere Wizmoto',
                'content' => 'Offriamo annunci verificati, messaggi sicuri, informazioni dettagliate sui veicoli e una rete di concessionari fidati. La nostra piattaforma garantisce trasparenza, sicurezza e convenienza per tutti gli utenti.'
            ],
            [
                'section' => 'values',
                'title' => 'I Nostri Valori',
                'content' => 'Trasparenza, Fiducia, Qualità e Soddisfazione del Cliente sono al centro di tutto ciò che facciamo. Crediamo nel creare relazioni durature con i nostri utenti e nel fornire un servizio eccezionale.'
            ],
        ];

        foreach ($aboutTranslations as $translation) {
            AboutUs::where('section', $translation['section'])->update([
                'title_it' => $translation['title'],
                'content_it' => $translation['content']
            ]);
        }

        $this->command->info('✓ About Us translations completed');
    }
}

