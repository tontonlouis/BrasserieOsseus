# Brasserie Osseus

#### Présentation 

La Brasserie Osseus (Ossuaire en latin) est née dans l’esprit d’amis voulant allier leurs passions pour ces excellents 
breuvages houblonnés et la musique métal. Nous avons fait le choix de mettre une partie de notre identité et de la faire 
transparaître dans nos bières et dans notre brasserie que ce soit par l’origine du nom, les visuels, ou encore les 
recettes pour le plaisir de vos squelettes. Nous nous reconnaissons dans des modèles de « Craft beer » américaines, 
scandinaves ou encore irlandaises et plutôt que de continuer de brasser en amateur au fond du garage, nous avons fait 
le choix de vous faire partager nos produits avec le désir de vous surprendre tant par des saveurs loin des standards 
industriels que par des étiquettes originales.


## Configuration
##### Installation

- git clone
- composer install
- npm install
- php bin/console doctrine:database:create
- php bin/console doctrine:migrations:migrate
- php bin/console doctrine:fixtures:load


##### Lancer le site 

- php bin/console server:run
- npm run dev-server

##### Lancer le serveur stmp

- maildev

 
#### Fixtures :
Banniere sold Out;
Add property Product -> IBU (int)
Message : Produit récup mag
Adresse de facturation ??
degree float ?
Quantity à la réservation du produit
no twitter


