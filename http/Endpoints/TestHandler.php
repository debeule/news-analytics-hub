<?php

declare(strict_types=1);

namespace Http\Endpoints;

use App\Imports\SyncAllSources;
use App\OpenAi\Commands\ProcessData;
use Illuminate\Foundation\Bus\DispatchesJobs;

class TestHandler
{
    use DispatchesJobs;

    // public function __invoke()
    // {
    //     $this->dispatchSync(new SyncAllSources);
    // }
    
    public function __invoke(): void
    {

        $articleContent = "Nieuwe deal duwt reisaanbieder Nordic richting omzetkaap van 150 miljoen | De TijdNieuwsOndernemenToerismeSchermvullende weergaveNordic is Belgisch marktleider voor Scandinaviëreizen. Die zijn onder meer populair voor het bezichtigen van het noorderlicht.Michaël Sephiha13 mei 2024Vandaag om11:02De aanbieder van Scandinaviëreizen Nordic koopt zijn Nederlandse sectorgenoot Norske, een specialist in Noorse zeereizen. Het is de zesde overname van het Vlaamse bedrijf in een halfjaar.Nordic en Norske werkten al langer samen rond zeereizen langs de Noorse kust en de poolgebieden. Dankzij de overname wordt Nordic boven de Moerdijk marktleider in dat soort reizen. Er is evenwel een wezenlijk verschil tussen de twee: anders dan Nordic verkoopt Norske zijn reizen ook via een selectie van reisbureaus. Nordic zal die samenwerking verderzetten.145 miljoenMet Norske erbij klimt de omzet van de Nordic-groep naar 145 miljoen euro: 130 miljoen daarvan zijn inkomsten als touroperator en 15 miljoen stroomt binnen via hotelboekingen.Sinds de instap van het investeringsfonds Down2Earthin 2019rijgt Nordic de overnames aaneen. De jongste zes maanden slorpte hetAskja Reizen, Go North Iceland, VNC Asia Travel, Nord Espaces enBeyond Bordersop. Met Norske erbij klimt de omzet van de Nordic-groep naar 145 miljoen euro: 130 miljoen daarvan zijn inkomsten als touroperator en 15 miljoen stroomt binnen via hotelboekingen. Ter vergelijking: voor de coronacrisis realiseerde Nordic minder dan 30 miljoen euro omzet.Down2Earth heeft de meerderheid (59%) van Nordic in handen. Het investeerde in Nordic via zijn tweede fonds. Ter herinnering: het eerste fonds van Down2Earth had 70 miljoen euro kapitaal, het tweede haalde bij een reeks investeerders 110 miljoen euro op.De investeerder is bezig aande inzameling van kapitaal van een nieuw, derde fonds. Het mikt op een vuurkracht van in totaal 150 miljoen euro. De oprichters van Down2Earth zijn Ivo Marechal, de ex-CEO van het transportbedrijf H.Essers, Alain Keppens en Peter Kloeck (beiden ex-Gimv).Gesponsorde inhoudTijd Connectbiedt organisaties toegang tot het netwerk van De Tijd. De partners zijn verantwoordelijk voor de inhoud.‘Wie zijn vermogen mee wil beheren, moet voorkeuren hebben’Voor particulieren zijn tijd, kennis en goesting onontbeerlijk om zelf hun vermogen te beheren. Ook belangrijk: een duidelijke voorkeur hebben. Lees meerWat gaat ú doen met uw duizend goed getrainde stagiairs?Met Take The Lead brengen De Tijd/L’Echo en Vlerick Business School een programma voor professionals die de technologische evolutie niet alleen willen begrijpen, maar ook ten volle exploiteren. Lees meer'We kijken nog altijd te weinig naar de ware economische kostprijs van vervuiling'In de Antwerpse haven, waar vroeger de Opel-fabriek stond, verrijst het NextGen-district, een hotspot voor circulaire economie. Ook de start-up Triple Helix Molecules as a Service (THX MaaS) neemt er zijn intrek met hun Sure Pure-initiatief rond recyclage van polyurethaan. ‘We willen er minstens 30.000 ton afval verwerken’, vertelt CEO Steven Peleman. Op termijn een investering van 65 tot 90 miljoen euro. Lees meer‘Een management-vennootschap kan vooral vanuit fiscaal perspectief interessant zijn'Veel zelfstandigen en vrije beroepers opteren ervoor om via een (management)vennootschap hun diensten aan te bieden. Lees meerPartner Contentbiedt organisaties toegang tot het netwerk van De Tijd. De partners zijn verantwoordelijk voor de inhoud.Wat houdt de war for talent nu precies in? En vooral: wie profiteert ervan?The war for talent woedt hard in België: 65 procent van de Belgische werkgevers heeft het moeilijk om personeel te vinden, het Europese gemiddelde bedraagt 42 procent.‘Met private equity kan je bedrijf een volgend niveau bereiken’Het West-Vlaamse technologiebedrijf Televic begon als fabrikant van professionele radiosystemen, maar innoveerde door de jaren heen flink om internationaal te groeienInvestment grade obligaties: een must in een goed gespreide portefeuilleBedrijfsobligaties kunnen de basis vormen van het obligatiegedeelte van een gespreide portefeuille. En het investment grade segment kan daarin een sleutelrol spelen.'Ons doel is: beter eten op een duurzamere en innovatieve manier, met zo weinig mogelijk afval'Ons dieet verrijken en verbeteren door wetenschappelijke innovatie en de link leggen naar de winkel of het restaurant. Dat is in een notendop de missie van Maxime Willems. Met zijn Foodlab Proef! beschikt hij over een onestopshop voor innovatieve voedingsproducten, van concept tot productie.Deze berichten zijn ingezonden, de bedrijven zijn verantwoordelijk voor de inhoud.partnerDe grenzen van een private stichtingpartnerHoe als ondernemer starten met verduurzamen?partnerOvername schoonmaakpersoneel gebeurt met zorgpartnerWorkforce management zorgt voor flexibeler hr-model op basis van werknemerservaring";
        
        $data = ProcessData::setup($articleContent)->execute();
        dd($data);
    }
}

