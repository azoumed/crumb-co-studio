# Product

<!-- impeccable:product-schema 1 -->

## Platform

web

## Users

Pâtissiers et pâtissières à domicile, débutants ou en croissance, qui vendent gâteaux, biscuits et autres pâtisseries depuis chez eux. Ils cuisinent, gèrent les commandes et font leur propre marketing, souvent seuls et souvent depuis leur téléphone. Leur besoin : des systèmes simples et prêts à l'emploi pour prendre des commandes, fixer leurs prix et se faire connaître, sans devoir les concevoir eux-mêmes.

Ils lisent et travaillent en anglais, arabe, français ou espagnol.

## Product Purpose

Crumb & Co. Studio est une boutique en ligne de produits numériques : des modèles modifiables qui donnent à une pâtisserie maison ses outils de commande, de tarification et de marketing. Le succès, c'est un pâtissier qui achète, ouvre son fichier, l'adapte à son activité et s'en sert la semaine même.

## Positioning

Ce qu'un vendeur de modèles génériques (Etsy, Creative Market) ne peut pas revendiquer honnêtement :

- **Pensé métier.** Chaque modèle part des besoins réels d'une pâtisserie maison (allergènes, acomptes, délais de commande), pas d'un design générique adapté après coup.
- **Écrit par quelqu'un du métier.** La personne derrière Crumb & Co. est ou a été pâtissière à domicile et vend les outils qu'elle utilise.
- **Un système, pas des pièces isolées.** Commandes, prix et marketing forment un ensemble assorti qui fonctionne d'un bout à l'autre.
- **Quatre langues, dont l'arabe en RTL.** Les modèles existent en anglais, arabe, français et espagnol.

## Operating Context

Les acheteurs modifient les produits dans les outils qu'ils ont déjà :

- **Canva** : menus, cartes de prix, flyers, publications pour les réseaux sociaux, étiquettes.
- **Tableurs** (Google Sheets / Excel) : calculateurs de prix, suivi des commandes et des coûts.
- **Formulaires et PDF** : bons de commande, contrats, fiches d'allergènes, factures (PDF modifiable ou Google Forms).
- **Packs / kits** : lots qui réunissent plusieurs modèles autour d'un besoin (lancement, fêtes, saisons, Ramadan, Noël).

Achat et livraison passent par WooCommerce : produits téléchargeables ou liens d'accès, sans expédition physique.

## Capabilities and Constraints

- **Stack existante :** WordPress avec thème bloc `crumb-co` (`theme.json`, `templates/`, `parts/`, `patterns/`, `assets/css/theme.css`) et extension `crumb-co-toolkit`, plus WooCommerce. Livrés dans `crumb-co-theme.zip` et `crumb-co-toolkit.zip` ; pas encore décompressés dans ce dossier au moment de l'init, le code n'a donc pas été inspecté.
- **Langues :** anglais, arabe (RTL), français, espagnol. Toute mise en page doit fonctionner dans les deux sens d'écriture.
- **Mobile d'abord :** la majorité des visiteurs arrive depuis un téléphone.
- **Performance :** conformité aux recommandations Google, Core Web Vitals au vert (LCP, INP, CLS).
- **À décider :** fonctionnement multilingue côté WordPress (extension de traduction, URL par langue), formats exacts livrés par produit, politique de remboursement et de licence. Ne rien affirmer sur ces points avant confirmation.

## Brand Commitments

- **Nom :** Crumb & Co. Studio.
- **Personnalité :** chaleureuse, inspirée de la pâtisserie, professionnelle, jamais enfantine.
- **Couleurs imposées :** fond crème `#FBF6EE`, texte cacao `#3B2A20`, accents framboise `#B8325A` et vert sauge `#7E9C7C`.
- **Polices imposées :** Fraunces (titres), Nunito (texte), Cairo (arabe).
- **Direction imposée :** beaucoup d'espace blanc, illustrations pâtissières sobres, maquettes produits claires.
- **Voix :** honnête et concrète. Aucun faux avis, chiffre ou garantie inventé.

## Evidence on Hand

- **Maquettes produits :** des visuels réels des modèles existent (chemins à préciser une fois les fichiers décompressés).
- **Illustrations pâtissières :** déjà créées (chemins à préciser).
- **Avis clients :** des avis réels existent (confirmé par la propriétaire du projet). Leur emplacement, leur source et l'accord des clients pour les publier restent à consigner ici. N'afficher que ces avis, mot pour mot, avec le prénom ou l'attribution que le client a acceptée ; ne jamais les reformuler, les embellir ni en ajouter.
- **Boutique :** pas encore de chiffres de vente ni de nombre de clients à citer.
- **Absences à ne jamais combler par de l'invention :** nombre de clients ou de ventes, notes moyennes, logos de presse, garanties de résultat (« doublez vos commandes »), compteurs d'urgence fictifs.

## Product Principles

1. **Utile la semaine même.** Chaque produit et chaque page se jugent à la vitesse à laquelle un pâtissier passe de l'achat à l'usage réel.
2. **La preuve est le produit.** Montrer les modèles eux-mêmes, clairement, plutôt que des promesses ; la confiance vient de ce qu'on voit, pas de ce qu'on affirme.
3. **Une seule boutique, quatre langues égales.** L'arabe et le RTL sont traités comme des versions à part entière, jamais comme une traduction de second rang.
4. **Professionnel sans froideur.** Le ton rassure un débutant et respecte quelqu'un qui en vit.
5. **Léger par défaut.** Un téléphone moyen sur réseau mobile est la cible ; chaque image, police et script doit gagner sa place.

## Accessibility & Inclusion

- **Standard requis :** WCAG niveau AA (version de référence à confirmer, 2.2 par défaut) sur l'ensemble de la boutique, parcours d'achat WooCommerce compris.
- Prise en charge complète du RTL (ordre de lecture, icônes directionnelles, formulaires) et du texte arabe avec Cairo.
- Utilisation à une main sur mobile, cibles tactiles confortables, lecture par lecteur d'écran des fiches produit et du panier.
