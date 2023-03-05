<?php
namespace App\DataFixtures;
use App\Entity\Film;
use App\Repository\FilmRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Comment;
class AppFixtures extends Fixture
{
    /**
     * Generates initialization data for films : [title, year]
     * @return \\Generator
     */
    private static function filmsDataGenerator()
    {
        yield ["Babylon", 1980];
        yield ["Babylon", 2023];
        yield ["E. T.", 2003];
        yield ["Lupin", 2021];
        yield ["Le prénom", 2012];
        yield ["Tirailleurs", 2022];
        yield ["Avatar", 2009];
        yield ["Avatar 2", 2022];
    }
    /**
     * Generates initialization data for film comments :
     * [film_title, film_year, comments]
     * @return \\Generator
     */
    private static function filmCommentsGenerator()
    {
        yield ["Babylon", 1980, "Balade sociale et musicale dans la banlieue anglaise des années 70"];
        yield ["Babylon", 2023, "Un film magistral, cruel, flamboyant."];
        yield ["Babylon", 2023, "Démesuré, renversant, Babylon est un bordel virtuose"];
        yield ["Lupin", 2021, " Omar Sy insuffle une nouvelle vie à un personnage littéraire"];
        yield ["Lupin", 2021, "Netflix modernise intelligemment le mythe d’Arsène Lupin "];
        yield ["Tirailleurs", 2022, "un tribut à des héros de l’ombre."];
        yield ["Tirailleurs", 2022, "Un mémorial subtil et magnifique."];
        yield ["Avatar ", 2009, "Une création exceptionnelle, un grand spectacle !"];
        yield ["Avatar 2", 2022, "Spectacle familial hyperimmersif"];
        yield ["Avatar 2", 2022, "Un conte humaniste et un très grand spectacle familial."];
    }
    
    public function load(ObjectManager $manager)
    {
        $filmRepo = $manager->getRepository(Film::class);
        
        foreach (self::filmsDataGenerator() as [$title, $year] ) {
            $film = new Film();
            $film->setTitle($title);
            $film->setYear($year);
            $manager->persist($film);
        }
        $manager->flush();
        
        foreach (self::filmCommentsGenerator() as [$title, $year, $comment])
        {
            $film = $filmRepo->findOneBy(['title' => $title, 'year' => $year]);
            $reco = new Comment();
            $reco->setComment($comment);
            $film->addComment($reco);
            //the cascade persist on fim-comments avoids persisting down the relation
            $manager->persist($film);
        }
        $manager->flush();
    }
}
