<?php

namespace Database\Seeders;

use App\Models\BlogCategory;
use App\Models\BlogPost;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BlogPostSeeder extends Seeder {
    public function run (): void {
        BlogPost::query()->truncate();
        $categories = BlogCategory::all();
        
        // Available blog images
        $blogImages = [
            'blog-1.jpg',
            'blog-2.jpg',
            'blog-3.jpg',
            'blog3-1.jpg',
            'blog3-2.jpg',
            'blog4-1.jpg',
            'blog4-2.jpg',
            'blog4-3.jpg',
            'blog4-4.jpg',
            'blog4-5.jpg',
            'blog4-6.jpg',
            'blog4-7.jpg',
            'blog4-8.jpg',
            'blog4-9.jpg',
            'blog5-1.jpg',
            'blog5-2.jpg',
            'blog5-3.jpg',
            'blog5-4.jpg',
            'blog5-5.jpg',
            'blog5-6.jpg',
            'inner-blog3-1.jpg',
            'inner-blog4-1.jpg',
        ];

        $posts = [
            [
                'title' => 'How to Buy a Used Car Online: Complete Guide for 2024',
                'title_it' => 'Come Comprare un\'Auto Usata Online: Guida Completa 2024',
                'summary' => 'Discover the essential steps to safely purchase a used vehicle through online marketplaces. Learn about verification, inspection, and negotiation strategies.',
                'summary_it' => 'Scopri i passaggi essenziali per acquistare in sicurezza un veicolo usato tramite marketplace online. Impara strategie di verifica, ispezione e negoziazione.',
                'body' => '<h2>Introduction to Online Car Buying</h2><p>The digital revolution has transformed how we buy and sell vehicles. Online marketplaces like Autoscout24, AutoTrader, and similar platforms offer thousands of listings at your fingertips. However, navigating these platforms requires knowledge and caution.</p><h2>Research and Verification</h2><p>Before making any purchase, thoroughly research the vehicle\'s history. Request a vehicle history report, verify the VIN number, and check for any outstanding finance or accidents. Use online tools to compare prices and ensure you\'re getting a fair deal.</p><h2>Inspection Checklist</h2><p>Even when buying online, arrange an in-person inspection or hire a professional inspector. Check the engine, transmission, body condition, and test drive the vehicle. Don\'t skip this crucial step.</p><h2>Negotiation Tips</h2><p>Use market data to negotiate effectively. Compare similar listings, understand depreciation rates, and be prepared to walk away if the deal doesn\'t meet your expectations.</p>',
                'body_it' => '<h2>Introduzione all\'Acquisto Online di Auto</h2><p>La rivoluzione digitale ha trasformato il modo in cui acquistiamo e vendiamo veicoli. I marketplace online come Autoscout24 offrono migliaia di annunci a portata di mano. Tuttavia, navigare queste piattaforme richiede conoscenza e cautela.</p><h2>Ricerca e Verifica</h2><p>Prima di qualsiasi acquisto, ricerca approfonditamente la storia del veicolo. Richiedi un rapporto storico, verifica il numero di telaio e controlla eventuali finanziamenti pendenti o incidenti.</p>',
                'slug' => 'how-to-buy-used-car-online-guide-2024',
                'author_name' => 'Sarah Johnson',
                'published' => true,
                'views' => 1250,
            ],
            [
                'title' => 'Top 10 Tips for Selling Your Vehicle on Online Marketplaces',
                'title_it' => 'Top 10 Consigli per Vendere il Tuo Veicolo sui Marketplace Online',
                'summary' => 'Maximize your vehicle\'s value and sell faster with these proven strategies for online marketplaces. From photography to pricing, learn what works.',
                'summary_it' => 'Massimizza il valore del tuo veicolo e vendi più velocemente con queste strategie collaudate per marketplace online. Dalla fotografia al prezzo, impara cosa funziona.',
                'body' => '<h2>Professional Photography</h2><p>High-quality photos are essential. Take pictures in good lighting, from multiple angles, and showcase both interior and exterior. Clean your vehicle thoroughly before photographing.</p><h2>Accurate Description</h2><p>Write a detailed, honest description highlighting key features, maintenance history, and any unique selling points. Transparency builds trust with potential buyers.</p><h2>Competitive Pricing</h2><p>Research similar vehicles in your area and price competitively. Consider market demand, vehicle condition, and mileage when setting your price.</p><h2>Respond Promptly</h2><p>Quick responses to inquiries show professionalism and keep potential buyers engaged. Be available for questions and test drives.</p>',
                'body_it' => '<h2>Fotografia Professionale</h2><p>Foto di alta qualità sono essenziali. Scatta foto con buona illuminazione, da più angolazioni, e mostra sia interno che esterno.</p>',
                'slug' => 'top-10-tips-selling-vehicle-online-marketplaces',
                'author_name' => 'Michael Chen',
                'published' => true,
                'views' => 2100,
            ],
            [
                'title' => 'Electric Vehicle Market Trends: What Buyers Need to Know in 2024',
                'title_it' => 'Tendenze del Mercato dei Veicoli Elettrici: Cosa Devono Sapere gli Acquirenti nel 2024',
                'summary' => 'Explore the latest trends in the electric vehicle marketplace, including pricing, availability, and what to consider when buying an EV.',
                'summary_it' => 'Esplora le ultime tendenze nel marketplace dei veicoli elettrici, inclusi prezzi, disponibilità e cosa considerare quando si acquista un\'auto elettrica.',
                'body' => '<h2>Growing EV Market</h2><p>The electric vehicle market is experiencing unprecedented growth. More manufacturers are entering the space, driving competition and innovation. Used EV prices are becoming more accessible as the market matures.</p><h2>Battery Technology Advances</h2><p>Modern EVs offer improved range and faster charging times. When buying used, check battery health reports and warranty status. Battery degradation is a key consideration for older models.</p><h2>Charging Infrastructure</h2><p>Before purchasing an EV, research charging options in your area. Home charging solutions and public charging networks are expanding rapidly, making EV ownership more practical.</p><h2>Resale Value Considerations</h2><p>EV depreciation patterns differ from traditional vehicles. Consider factors like battery warranty, model popularity, and technological obsolescence when evaluating resale potential.</p>',
                'body_it' => '<h2>Mercato EV in Crescita</h2><p>Il mercato dei veicoli elettrici sta vivendo una crescita senza precedenti. Più produttori stanno entrando nello spazio, guidando competizione e innovazione.</p>',
                'slug' => 'electric-vehicle-market-trends-2024',
                'author_name' => 'Emma Rodriguez',
                'published' => true,
                'views' => 3400,
            ],
            [
                'title' => 'Motorcycle Marketplace Guide: Finding Your Perfect Ride',
                'title_it' => 'Guida al Marketplace delle Motociclette: Trovare la Tua Moto Perfetta',
                'summary' => 'Navigate motorcycle marketplaces effectively with this comprehensive guide covering everything from sport bikes to cruisers and touring motorcycles.',
                'summary_it' => 'Naviga efficacemente i marketplace delle motociclette con questa guida completa che copre tutto dalle sportive alle cruiser e touring.',
                'body' => '<h2>Understanding Motorcycle Categories</h2><p>Motorcycles come in various categories: sport bikes, cruisers, touring, adventure, and more. Each type serves different purposes and appeals to different riders. Understanding these categories helps narrow your search.</p><h2>Key Considerations</h2><p>When browsing motorcycle listings, consider engine size, mileage, maintenance history, and modifications. Motorcycles require different maintenance than cars, so service records are crucial.</p><h2>Safety and Inspection</h2><p>Always inspect motorcycles thoroughly. Check tire condition, brake functionality, chain/belt maintenance, and look for signs of accidents or damage. A professional inspection is recommended for high-value purchases.</p><h2>Test Ride Importance</h2><p>Test rides are essential for motorcycles. Feel the handling, check comfort, and verify all systems work correctly. Bring appropriate safety gear and ensure you\'re insured for test rides.</p>',
                'body_it' => '<h2>Comprendere le Categorie di Motociclette</h2><p>Le motociclette arrivano in varie categorie: sportive, cruiser, touring, adventure e altro. Ogni tipo serve scopi diversi e attira diversi motociclisti.</p>',
                'slug' => 'motorcycle-marketplace-guide-finding-perfect-ride',
                'author_name' => 'David Thompson',
                'published' => true,
                'views' => 1890,
            ],
            [
                'title' => 'Price Negotiation Strategies for Online Vehicle Purchases',
                'title_it' => 'Strategie di Negoziazione del Prezzo per Acquisti Online di Veicoli',
                'summary' => 'Master the art of negotiation when buying vehicles online. Learn effective techniques to secure the best price while maintaining a positive relationship with sellers.',
                'summary_it' => 'Padroneggia l\'arte della negoziazione quando acquisti veicoli online. Impara tecniche efficaci per ottenere il miglior prezzo mantenendo una relazione positiva con i venditori.',
                'body' => '<h2>Research Market Prices</h2><p>Before negotiating, research comparable vehicles in your area. Use online tools and market analysis to understand fair pricing. Knowledge is your strongest negotiating tool.</p><h2>Identify Negotiation Points</h2><p>Look for factors that justify a lower price: high mileage, cosmetic issues, lack of service history, or time on market. Use these points constructively in discussions.</p><h2>Communication Strategy</h2><p>Be respectful and professional. Express genuine interest while being clear about your budget constraints. Build rapport before discussing price.</p><h2>Know When to Walk Away</h2><p>Set your maximum price before negotiations begin. If the seller won\'t meet your reasonable offer, be prepared to walk away. There are always other vehicles available.</p>',
                'body_it' => '<h2>Ricerca dei Prezzi di Mercato</h2><p>Prima di negoziare, ricerca veicoli comparabili nella tua zona. Usa strumenti online e analisi di mercato per capire prezzi equi.</p>',
                'slug' => 'price-negotiation-strategies-online-vehicle-purchases',
                'author_name' => 'Lisa Anderson',
                'published' => true,
                'views' => 2750,
            ],
            [
                'title' => 'Essential Vehicle Inspection Checklist Before Purchase',
                'title_it' => 'Checklist Essenziale di Ispezione Veicolo Prima dell\'Acquisto',
                'summary' => 'Don\'t skip the inspection! Use this comprehensive checklist to evaluate any vehicle before making your purchase decision.',
                'summary_it' => 'Non saltare l\'ispezione! Usa questa checklist completa per valutare qualsiasi veicolo prima di prendere la tua decisione di acquisto.',
                'body' => '<h2>Exterior Inspection</h2><p>Check for rust, dents, paint mismatches, and panel gaps. Uneven gaps may indicate accident damage. Inspect tires for wear patterns and age.</p><h2>Interior Check</h2><p>Examine seats, dashboard, and controls for wear. Test all electronics, air conditioning, and infotainment systems. Check for water damage or unusual odors.</p><h2>Mechanical Inspection</h2><p>Start the engine cold and listen for unusual noises. Check fluid levels and colors. Test brakes, steering, and suspension. A professional mechanic inspection is highly recommended.</p><h2>Test Drive</h2><p>Drive on various road conditions. Test acceleration, braking, handling, and transmission shifts. Pay attention to vibrations, noises, or warning lights.</p>',
                'body_it' => '<h2>Ispezione Esterna</h2><p>Controlla ruggine, ammaccature, discrepanze di vernice e spazi tra pannelli. Spazi irregolari possono indicare danni da incidente.</p>',
                'slug' => 'essential-vehicle-inspection-checklist-before-purchase',
                'author_name' => 'Robert Martinez',
                'published' => true,
                'views' => 3200,
            ],
            [
                'title' => 'Financing Options for Online Vehicle Purchases',
                'title_it' => 'Opzioni di Finanziamento per Acquisti Online di Veicoli',
                'summary' => 'Explore various financing options available when purchasing vehicles through online marketplaces, from dealer financing to personal loans.',
                'summary_it' => 'Esplora varie opzioni di finanziamento disponibili quando acquisti veicoli tramite marketplace online, dal finanziamento del concessionario ai prestiti personali.',
                'body' => '<h2>Dealer Financing</h2><p>Many online marketplaces partner with dealers offering financing options. These can be convenient but compare rates with other lenders. Dealers may offer promotional rates for qualified buyers.</p><h2>Bank and Credit Union Loans</h2><p>Traditional lenders often offer competitive rates, especially for buyers with good credit. Pre-approval gives you negotiating power and helps set your budget.</p><h2>Online Lenders</h2><p>Digital lenders provide quick approval processes and competitive rates. Compare multiple offers and read terms carefully, especially regarding early payment penalties.</p><h2>Leasing Considerations</h2><p>Leasing may be an option for new or certified pre-owned vehicles. Understand mileage limits, wear charges, and end-of-lease options before committing.</p>',
                'body_it' => '<h2>Finanziamento Concessionario</h2><p>Molti marketplace online collaborano con concessionari che offrono opzioni di finanziamento. Questi possono essere convenienti ma confronta i tassi con altri finanziatori.</p>',
                'slug' => 'financing-options-online-vehicle-purchases',
                'author_name' => 'Jennifer Lee',
                'published' => true,
                'views' => 1650,
            ],
            [
                'title' => '2024 Motor Vehicle Market Analysis and Predictions',
                'title_it' => 'Analisi e Previsioni del Mercato dei Veicoli a Motore 2024',
                'summary' => 'Stay ahead with insights into current market trends, pricing dynamics, and future predictions for the motor vehicle marketplace.',
                'summary_it' => 'Resta al passo con approfondimenti su tendenze di mercato attuali, dinamiche dei prezzi e previsioni future per il marketplace dei veicoli a motore.',
                'body' => '<h2>Current Market Trends</h2><p>The motor vehicle market continues evolving with supply chain recovery, changing consumer preferences, and technological advances. Used vehicle prices are stabilizing after recent volatility.</p><h2>Segment Analysis</h2><p>Different vehicle segments show varying trends. SUVs and electric vehicles maintain strong demand, while sedans face declining interest. Luxury and performance vehicles show resilience.</p><h2>Regional Variations</h2><p>Market conditions vary significantly by region. Urban areas show stronger EV adoption, while rural markets favor trucks and SUVs. Understanding regional dynamics helps buyers and sellers.</p><h2>Future Outlook</h2><p>Expect continued growth in electric vehicle adoption, improved supply chain stability, and evolving consumer preferences toward sustainability and technology integration.</p>',
                'body_it' => '<h2>Tendenze di Mercato Attuali</h2><p>Il mercato dei veicoli a motore continua ad evolversi con il recupero della catena di approvvigionamento, preferenze dei consumatori in cambiamento e progressi tecnologici.</p>',
                'slug' => '2024-motor-vehicle-market-analysis-predictions',
                'author_name' => 'James Wilson',
                'published' => true,
                'views' => 4100,
            ],
            [
                'title' => 'Safety Tips for Buying Vehicles Online: Avoiding Scams',
                'title_it' => 'Consigli di Sicurezza per Acquistare Veicoli Online: Evitare le Truffe',
                'summary' => 'Protect yourself from online vehicle scams with these essential safety tips and red flags to watch for when browsing listings.',
                'summary_it' => 'Proteggiti dalle truffe online sui veicoli con questi consigli di sicurezza essenziali e segnali di allarme da osservare quando navighi gli annunci.',
                'body' => '<h2>Red Flags to Watch</h2><p>Be wary of prices significantly below market value, sellers requesting wire transfers or gift cards, and listings with poor quality photos. These are common scam indicators.</p><h2>Verification Steps</h2><p>Always verify seller identity, request vehicle history reports, and use secure payment methods. Meet in person or use escrow services for high-value transactions.</p><h2>Communication Patterns</h2><p>Legitimate sellers respond professionally and provide detailed information. Be cautious of sellers avoiding questions, using pressure tactics, or requesting unusual payment methods.</p><h2>Platform Safety Features</h2><p>Use reputable platforms with buyer protection programs, verified seller badges, and secure payment processing. Read platform policies and user reviews before engaging.</p>',
                'body_it' => '<h2>Segnali di Allarme da Osservare</h2><p>Diffida di prezzi significativamente sotto il valore di mercato, venditori che richiedono bonifici o carte regalo, e annunci con foto di scarsa qualità.</p>',
                'slug' => 'safety-tips-buying-vehicles-online-avoiding-scams',
                'author_name' => 'Patricia Brown',
                'published' => true,
                'views' => 2900,
            ],
            [
                'title' => 'Best Time to Buy and Sell Vehicles: Seasonal Guide',
                'title_it' => 'Miglior Momento per Comprare e Vendere Veicoli: Guida Stagionale',
                'summary' => 'Timing matters! Learn when to buy and sell vehicles for the best deals, considering seasonal trends and market cycles.',
                'summary_it' => 'Il tempismo conta! Impara quando comprare e vendere veicoli per i migliori affari, considerando tendenze stagionali e cicli di mercato.',
                'body' => '<h2>Best Months to Buy</h2><p>Late fall and winter often offer better deals as demand decreases. End of month, quarter, and year can bring dealer incentives. Convertibles and motorcycles may be cheaper in off-seasons.</p><h2>Best Months to Sell</h2><p>Spring and early summer typically see increased demand. Convertibles and motorcycles sell better in warm months. SUVs and trucks may command higher prices before winter.</p><h2>Model Year Transitions</h2><p>When new model years arrive, previous year models often see price reductions. This can be an excellent time to buy if you don\'t need the latest features.</p><h2>Market Events</h2><p>Monitor market events like new model releases, manufacturer incentives, and economic factors that influence supply and demand dynamics.</p>',
                'body_it' => '<h2>Migliori Mesi per Comprare</h2><p>Fine autunno e inverno spesso offrono affari migliori poiché la domanda diminuisce. Fine mese, trimestre e anno possono portare incentivi del concessionario.</p>',
                'slug' => 'best-time-buy-sell-vehicles-seasonal-guide',
                'author_name' => 'Thomas Garcia',
                'published' => true,
                'views' => 2250,
            ],
            [
                'title' => 'Understanding Vehicle History Reports: What to Look For',
                'title_it' => 'Comprendere i Rapporti Storici dei Veicoli: Cosa Cercare',
                'summary' => 'Vehicle history reports are crucial for informed purchases. Learn how to read and interpret these reports to make better buying decisions.',
                'summary_it' => 'I rapporti storici dei veicoli sono cruciali per acquisti informati. Impara come leggere e interpretare questi rapporti per prendere decisioni di acquisto migliori.',
                'body' => '<h2>Key Information in Reports</h2><p>History reports show accident records, title status, odometer readings, service history, and previous owners. Each piece of information helps assess vehicle condition and value.</p><h2>Red Flags</h2><p>Watch for salvage titles, flood damage, odometer discrepancies, and multiple accidents. These factors significantly impact value and safety.</p><h2>Service History Importance</h2><p>Regular maintenance records indicate proper care. Gaps in service history or missing records may suggest neglect or incomplete documentation.</p><h2>Multiple Report Sources</h2><p>Consider obtaining reports from multiple sources as they may contain different information. Popular services include Carfax, AutoCheck, and manufacturer-specific reports.</p>',
                'body_it' => '<h2>Informazioni Chiave nei Rapporti</h2><p>I rapporti storici mostrano registri di incidenti, stato del titolo, letture del contachilometri, storia del servizio e proprietari precedenti.</p>',
                'slug' => 'understanding-vehicle-history-reports-what-to-look-for',
                'author_name' => 'Amanda White',
                'published' => true,
                'views' => 3800,
            ],
            [
                'title' => 'Dealer vs Private Seller: Pros and Cons for Buyers',
                'title_it' => 'Concessionario vs Venditore Privato: Pro e Contro per gli Acquirenti',
                'summary' => 'Compare buying from dealers versus private sellers to determine which option best fits your needs and budget.',
                'summary_it' => 'Confronta l\'acquisto da concessionari rispetto ai venditori privati per determinare quale opzione si adatta meglio alle tue esigenze e budget.',
                'body' => '<h2>Dealer Advantages</h2><p>Dealers offer warranties, financing options, trade-in opportunities, and professional service. They handle paperwork and often provide certified pre-owned programs with extended warranties.</p><h2>Dealer Disadvantages</h2><p>Dealer prices are typically higher due to overhead costs. Sales pressure and additional fees can increase total cost. Less room for negotiation compared to private sellers.</p><h2>Private Seller Advantages</h2><p>Private sellers often offer lower prices and more negotiation flexibility. You can speak directly with the owner about vehicle history and maintenance.</p><h2>Private Seller Considerations</h2><p>No warranties, limited financing options, and you handle all paperwork. Requires more due diligence and may involve more risk without proper verification.</p>',
                'body_it' => '<h2>Vantaggi del Concessionario</h2><p>I concessionari offrono garanzie, opzioni di finanziamento, opportunità di permuta e servizio professionale.</p>',
                'slug' => 'dealer-vs-private-seller-pros-cons-buyers',
                'author_name' => 'Christopher Taylor',
                'published' => true,
                'views' => 1950,
            ],
            [
                'title' => 'Importing and Exporting Vehicles: International Marketplace Guide',
                'title_it' => 'Importazione ed Esportazione di Veicoli: Guida al Marketplace Internazionale',
                'summary' => 'Navigate the complexities of importing and exporting vehicles through international marketplaces, including regulations, costs, and procedures.',
                'summary_it' => 'Naviga le complessità dell\'importazione ed esportazione di veicoli tramite marketplace internazionali, inclusi regolamenti, costi e procedure.',
                'body' => '<h2>Regulatory Requirements</h2><p>Each country has specific regulations for vehicle imports. Research customs duties, emissions standards, safety requirements, and documentation needed before importing.</p><h2>Cost Considerations</h2><p>Import costs include shipping, customs duties, taxes, and compliance modifications. Factor in all expenses when comparing prices to domestic options.</p><h2>Popular Import Markets</h2><p>Some regions offer vehicles at lower prices or with features unavailable domestically. Research market reputation and verify vehicle authenticity before purchasing.</p><h2>Export Procedures</h2><p>When exporting, ensure proper documentation, understand destination country requirements, and work with reputable shipping companies. Some vehicles may be restricted from export.</p>',
                'body_it' => '<h2>Requisiti Normativi</h2><p>Ogni paese ha regolamenti specifici per l\'importazione di veicoli. Ricerca dazi doganali, standard di emissione, requisiti di sicurezza e documentazione necessaria.</p>',
                'slug' => 'importing-exporting-vehicles-international-marketplace-guide',
                'author_name' => 'Maria Gonzalez',
                'published' => true,
                'views' => 1450,
            ],
            [
                'title' => 'Classic Car Marketplace: Investing in Vintage Vehicles',
                'title_it' => 'Marketplace delle Auto Classiche: Investire in Veicoli Vintage',
                'summary' => 'Explore the classic car market, including what makes a vehicle collectible, investment potential, and where to find authentic classics.',
                'summary_it' => 'Esplora il mercato delle auto classiche, inclusi cosa rende un veicolo da collezione, potenziale di investimento e dove trovare classici autentici.',
                'body' => '<h2>What Makes a Classic</h2><p>Classic cars typically have historical significance, rarity, design appeal, or cultural importance. Age alone doesn\'t define a classic; condition, originality, and provenance matter greatly.</p><h2>Investment Considerations</h2><p>Classic cars can appreciate in value, but they\'re not guaranteed investments. Research market trends, attend auctions, and consult experts before significant purchases.</p><h2>Authenticity and Documentation</h2><p>Verify authenticity through VIN numbers, production records, and expert appraisals. Original documentation, service records, and ownership history significantly impact value.</p><h2>Maintenance and Storage</h2><p>Classic cars require specialized maintenance and proper storage conditions. Factor ongoing costs into investment calculations. Join clubs and communities for support and knowledge.</p>',
                'body_it' => '<h2>Cosa Rende un\'Auto Classica</h2><p>Le auto classiche tipicamente hanno significato storico, rarità, appeal del design o importanza culturale.</p>',
                'slug' => 'classic-car-marketplace-investing-vintage-vehicles',
                'author_name' => 'Daniel Harris',
                'published' => true,
                'views' => 2200,
            ],
            [
                'title' => 'Motorcycle Maintenance Tips for Resale Value',
                'title_it' => 'Consigli di Manutenzione Motociclette per il Valore di Rivendita',
                'summary' => 'Maintain your motorcycle properly to maximize resale value. Learn essential maintenance practices that buyers look for.',
                'summary_it' => 'Mantieni la tua motocicletta correttamente per massimizzare il valore di rivendita. Impara pratiche di manutenzione essenziali che i compratori cercano.',
                'body' => '<h2>Regular Service Records</h2><p>Keep detailed service records showing regular oil changes, chain maintenance, tire replacements, and scheduled services. Complete documentation increases buyer confidence and value.</p><h2>Chain and Belt Maintenance</h2><p>Motorcycle chains and belts require regular cleaning, lubrication, and adjustment. Neglected chains show visible wear and reduce value significantly.</p><h2>Tire Condition</h2><p>Check tire age and wear regularly. Replace tires before they become unsafe. Good tires are a major selling point and safety requirement.</p><h2>Cosmetic Care</h2><p>Keep your motorcycle clean and protected from elements. Address scratches and rust promptly. Well-maintained appearance commands higher prices.</p>',
                'body_it' => '<h2>Registri di Servizio Regolari</h2><p>Mantieni registri di servizio dettagliati che mostrano cambi d\'olio regolari, manutenzione della catena, sostituzioni di pneumatici e servizi programmati.</p>',
                'slug' => 'motorcycle-maintenance-tips-resale-value',
                'author_name' => 'Rachel Moore',
                'published' => true,
                'views' => 1750,
            ],
            [
                'title' => 'EV Charging Infrastructure: What Buyers Should Know',
                'title_it' => 'Infrastruttura di Ricarica EV: Cosa Devono Sapere gli Acquirenti',
                'summary' => 'Understand EV charging options, from home installations to public networks, before purchasing an electric vehicle.',
                'summary_it' => 'Comprendi le opzioni di ricarica EV, dalle installazioni domestiche alle reti pubbliche, prima di acquistare un veicolo elettrico.',
                'body' => '<h2>Home Charging Solutions</h2><p>Most EV owners charge at home using Level 2 chargers. Installation costs vary, and you may need electrical upgrades. Consider your daily driving needs when choosing charger capacity.</p><h2>Public Charging Networks</h2><p>Public charging infrastructure is expanding rapidly. Research networks in your area, understand pricing models, and check compatibility with your vehicle\'s charging port.</p><h2>Charging Speeds</h2><p>Level 1 (standard outlet), Level 2 (240V), and DC fast charging offer different speeds. Fast charging is convenient for long trips but may impact battery longevity if used excessively.</p><h2>Cost Considerations</h2><p>Factor charging costs into ownership calculations. Home charging is typically cheaper than public stations. Some networks offer subscription plans for frequent users.</p>',
                'body_it' => '<h2>Soluzioni di Ricarica Domestica</h2><p>La maggior parte dei proprietari di EV ricarica a casa usando caricatori di livello 2. I costi di installazione variano e potresti aver bisogno di aggiornamenti elettrici.</p>',
                'slug' => 'ev-charging-infrastructure-what-buyers-should-know',
                'author_name' => 'Kevin Johnson',
                'published' => true,
                'views' => 2600,
            ],
            [
                'title' => 'Vehicle Insurance Guide for Online Purchases',
                'title_it' => 'Guida all\'Assicurazione Veicoli per Acquisti Online',
                'summary' => 'Navigate vehicle insurance requirements and options when buying through online marketplaces, ensuring proper coverage from day one.',
                'summary_it' => 'Naviga i requisiti e le opzioni di assicurazione veicoli quando acquisti tramite marketplace online, assicurando una copertura adeguata dal primo giorno.',
                'body' => '<h2>Insurance Requirements</h2><p>Most regions require minimum liability insurance before driving. Research local requirements and ensure coverage is active before taking possession of your vehicle.</p><h2>Coverage Types</h2><p>Liability covers damage to others, while comprehensive and collision protect your vehicle. Consider your vehicle\'s value, driving habits, and financial situation when choosing coverage levels.</p><h2>Online Purchase Considerations</h2><p>When buying online, coordinate insurance activation with purchase completion. Some insurers offer temporary coverage for test drives and transfers.</p><h2>Comparing Quotes</h2><p>Get quotes from multiple insurers before purchasing. Factors affecting rates include vehicle type, age, your driving history, location, and usage patterns.</p>',
                'body_it' => '<h2>Requisiti di Assicurazione</h2><p>La maggior parte delle regioni richiede un\'assicurazione di responsabilità civile minima prima di guidare.</p>',
                'slug' => 'vehicle-insurance-guide-online-purchases',
                'author_name' => 'Nicole Davis',
                'published' => true,
                'views' => 1850,
            ],
            [
                'title' => 'The Role of Customer Reviews in Vehicle Marketplaces',
                'title_it' => 'Il Ruolo delle Recensioni dei Clienti nei Marketplace di Veicoli',
                'summary' => 'Learn how to use customer reviews effectively when buying and selling vehicles online, and understand their impact on marketplace trust.',
                'summary_it' => 'Impara come usare efficacemente le recensioni dei clienti quando compri e vendi veicoli online, e comprendi il loro impatto sulla fiducia del marketplace.',
                'body' => '<h2>Reading Reviews Effectively</h2><p>Look for patterns in reviews rather than focusing on individual comments. Multiple mentions of the same issue indicate real problems. Consider review dates and relevance.</p><h2>Seller Reputation</h2><p>Check seller ratings, response rates, and review history. Established sellers with consistent positive feedback are generally more trustworthy than new accounts.</p><h2>Verification and Authenticity</h2><p>Be aware that some reviews may be fake or incentivized. Look for detailed, specific reviews over generic praise. Verified purchase badges add credibility.</p><h2>Leaving Reviews</h2><p>After your purchase, leave honest, detailed reviews to help future buyers. Include specific information about your experience, vehicle condition, and seller communication.</p>',
                'body_it' => '<h2>Leggere le Recensioni Efficacemente</h2><p>Cerca modelli nelle recensioni piuttosto che concentrarti su commenti individuali. Multiple menzioni dello stesso problema indicano problemi reali.</p>',
                'slug' => 'role-customer-reviews-vehicle-marketplaces',
                'author_name' => 'Steven Clark',
                'published' => true,
                'views' => 1550,
            ],
            [
                'title' => 'Future of Online Vehicle Marketplaces: Technology Trends',
                'title_it' => 'Futuro dei Marketplace Online di Veicoli: Tendenze Tecnologiche',
                'summary' => 'Explore emerging technologies shaping the future of online vehicle marketplaces, from AI to virtual reality and blockchain.',
                'summary_it' => 'Esplora le tecnologie emergenti che modellano il futuro dei marketplace online di veicoli, dall\'IA alla realtà virtuale e blockchain.',
                'body' => '<h2>Artificial Intelligence Integration</h2><p>AI is revolutionizing vehicle marketplaces through intelligent search, price prediction, and personalized recommendations. Chatbots assist buyers 24/7, while AI helps detect fraud and verify listings.</p><h2>Virtual and Augmented Reality</h2><p>VR and AR technologies allow virtual vehicle inspections and test drives. Buyers can explore vehicles remotely, reducing the need for physical visits and expanding market reach.</p><h2>Blockchain and Transparency</h2><p>Blockchain technology enables immutable vehicle history records, transparent transactions, and smart contracts. This increases trust and reduces fraud in online marketplaces.</p><h2>Mobile-First Experience</h2><p>Marketplaces are optimizing for mobile devices with app-first approaches. Mobile features include instant notifications, easy photo uploads, and streamlined purchase processes.</p>',
                'body_it' => '<h2>Integrazione dell\'Intelligenza Artificiale</h2><p>L\'IA sta rivoluzionando i marketplace di veicoli attraverso ricerca intelligente, previsione dei prezzi e raccomandazioni personalizzate.</p>',
                'slug' => 'future-online-vehicle-marketplaces-technology-trends',
                'author_name' => 'Laura Martinez',
                'published' => true,
                'views' => 3300,
            ],
        ];

        foreach ($posts as $index => $postData) {
            $post = BlogPost::create([
                'title' => $postData['title'],
                'title_it' => $postData['title_it'],
                'summary' => $postData['summary'],
                'summary_it' => $postData['summary_it'],
                'body' => $postData['body'],
                'body_it' => $postData['body_it'],
                'slug' => $postData['slug'],
                'author_name' => $postData['author_name'],
                'published' => $postData['published'],
                'views' => $postData['views'],
                'admin_id' => 1,
            ]);

            // Assign random category if available
            if ($categories->count() > 0) {
                $post->blog_category_id = $categories->random()->id;
                $post->save();
            }

            // Add image to the post
            $imageIndex = $index % count($blogImages);
            $imagePath = public_path('wizmoto/images/resource/' . $blogImages[$imageIndex]);
            
            if (file_exists($imagePath)) {
                $post->addMedia($imagePath)
                     ->preservingOriginal()
                     ->toMediaCollection('images');
            }
        }

        $this->command->info('✓ Seeded 20 blog posts about motor marketplaces');
    }
}
