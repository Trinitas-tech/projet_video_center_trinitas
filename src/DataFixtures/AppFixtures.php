<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Video;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    public function __construct(private UserPasswordHasherInterface $passwordHasher)
    {
    }

    public function load(ObjectManager $manager): void
    {
        // ===== Utilisateurs : minimum 4, dont 1 non vérifié =====
        $usersData = [
            ['email' => 'trinitas@cfitech.be', 'firstname' => 'Trinitas', 'lastname' => 'Ntirampeba', 'verified' => true],
            ['email' => 'jean.dupont@example.com', 'firstname' => 'Jean', 'lastname' => 'Dupont', 'verified' => true],
            ['email' => 'marie.martin@example.com', 'firstname' => 'Marie', 'lastname' => 'Martin', 'verified' => true],
            ['email' => 'paul.durand@example.com', 'firstname' => 'Paul', 'lastname' => 'Durand', 'verified' => false],
        ];

        $users = [];
        foreach ($usersData as $data) {
            $user = new User();
            $user->setEmail($data['email'])
                ->setFirstname($data['firstname'])
                ->setLastname($data['lastname'])
                ->setIsVerified($data['verified'])
                ->setPassword($this->passwordHasher->hashPassword($user, 'password123'));
            $manager->persist($user);
            $users[] = $user;
        }

        // ===== Vidéos : minimum 20, dont 8 non premium =====
        $videosData = [
            // 8 vidéos non premium
            ['Ngwiza', 'https://www.youtube.com/watch?v=ho_IGrAkUSs', 'Première vidéo de mon propre site Vidéo Center.', false],
            ['NGWIZA - Ballet Royal du Burundi', 'https://www.youtube.com/watch?v=ho_IGrAkUSs', 'Performance du Ballet Royal du Burundi, remix BGM du chant traditionnel Ngwiza.', false],
            ['Never Gonna Give You Up', 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', 'Le clip culte de Rick Astley qui a marqué toute une génération.', false],
            ['Gangnam Style', 'https://www.youtube.com/watch?v=9bZkp7q19f0', 'Le phénomène mondial de PSY qui a battu tous les records de vues.', false],
            ['Despacito', 'https://www.youtube.com/watch?v=kJQP7kiw5Fk', 'Luis Fonsi et Daddy Yankee dans le tube latino le plus écouté au monde.', false],
            ['Shape of You', 'https://www.youtube.com/watch?v=JGwWNGJdvx8', 'Ed Sheeran avec son hit incontournable de l\'année 2017.', false],
            ['See You Again', 'https://www.youtube.com/watch?v=RgKAFK5djSk', 'Wiz Khalifa et Charlie Puth pour l\'hommage émouvant de Fast and Furious 7.', false],
            ['Uptown Funk', 'https://www.youtube.com/watch?v=OPf0YbXqDm0', 'Mark Ronson et Bruno Mars dans un clip funky plein d\'énergie.', false],
            // 12 vidéos premium
            ['Roar', 'https://www.youtube.com/watch?v=CevxZvSJLk8', 'Katy Perry dans la jungle avec ce clip spectaculaire et coloré.', true],
            ['Counting Stars', 'https://www.youtube.com/watch?v=hT_nvWreIhg', 'OneRepublic et leur titre entraînant devenu un classique moderne.', true],
            ['Hello', 'https://www.youtube.com/watch?v=YQHsXMglC9A', 'Adele fait son grand retour avec cette ballade puissante et émouvante.', true],
            ['Sugar', 'https://www.youtube.com/watch?v=09R8_2nJtjg', 'Maroon 5 s\'invite par surprise dans des mariages à travers ce clip.', true],
            ['Bohemian Rhapsody', 'https://www.youtube.com/watch?v=fJ9rUzIMcZQ', 'Le chef-d\'œuvre intemporel de Queen, une œuvre unique en son genre.', true],
            ['Blank Space', 'https://www.youtube.com/watch?v=e-ORhEE9VVg', 'Taylor Swift dans un manoir somptueux pour ce clip devenu iconique.', true],
            ['Waka Waka', 'https://www.youtube.com/watch?v=pRpeEdMmmQ0', 'Shakira et l\'hymne officiel de la Coupe du Monde 2010 en Afrique du Sud.', true],
            ['Radioactive', 'https://www.youtube.com/watch?v=ktvTqknDobU', 'Imagine Dragons dans un clip sombre et mystérieux plein de surprises.', true],
            ['Faded', 'https://www.youtube.com/watch?v=60ItHLz5WEA', 'Alan Walker et son titre électro mélancolique connu dans le monde entier.', true],
            ['Thinking Out Loud', 'https://www.youtube.com/watch?v=lp-EO5I60KA', 'Ed Sheeran danse dans cette ballade romantique pleine de douceur.', true],
            ['Perfect', 'https://www.youtube.com/watch?v=2Vv-BfVoq4g', 'La déclaration d\'amour d\'Ed Sheeran dans un décor enneigé magnifique.', true],
            ['Take On Me', 'https://www.youtube.com/watch?v=djV11Xbc914', 'Le clip d\'animation révolutionnaire de A-ha, un classique des années 80.', true],
        ];

        foreach ($videosData as $i => [$title, $link, $description, $premium]) {
            $video = new Video();
            $video->setTitle($title)
                ->setVideoLink($link)
                ->setDescription($description)
                ->setPremiumVideo($premium)
                ->setUser($users[$i % count($users)]);
            $manager->persist($video);
        }

        $manager->flush();
    }
}
