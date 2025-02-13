Ce document présente la conception d'une base de données pour une boutique en ligne.

# Énoncé

On souhaite informatiser une **boutique** en ligne. Les **clients** ont un _numéro unique_, un _nom_ et une _adresse_. 

Les **clients** passent des **commandes** à une _date_ donnée et les commandes sont identifiées par un _numéro unique_. 

Elles ont des **lignes de détails** qui référencent chaque **produit** commandé ainsi que la _quantité_ commandée. 

Les **produits** sont identifiés par un _numéro unique_, ont un _label_, une _description_ et un _prix unitaire_.

# Décomposition

## Propositions élémentaires

1. La boutique en ligne doit être informatisée.
2. Chaque client a un numéro unique.
3. Chaque client a un nom.
4. Chaque client a une adresse.
5. Les clients passent des commandes à une date donnée.
6. Chaque commande est identifiée par un numéro unique.
7. Les commandes contiennent des lignes de détails.
8. Chaque ligne de détail référence un produit commandé.
9. Chaque ligne de détail indique la quantité commandée.
10. Chaque produit est identifié par un numéro unique.
11. Chaque produit a un label.
12. Chaque produit a une description.
13. Chaque produit a un prix unitaire.

## Propositions retenues

2. Chaque client a un numéro unique.
3. Chaque client a un nom.
4. Chaque client a une adresse.
5. Les clients passent des commandes à une date donnée.
6. Chaque commande est identifiée par un numéro unique.
7. Les commandes contiennent des lignes de détails.
8. Chaque ligne de détail référence un produit commandé.
9. Chaque ligne de détail indique la quantité commandée.
10. Chaque produit est identifié par un numéro unique.
11. Chaque produit a un label.
12. Chaque produit a une description.
13. Chaque produit a un prix unitaire.

# Modèle conceptuel de données

## Entités

D'après l'énoncé, on a identifié les types d'entités suivantes:

- **Client** : Les clients de la boutique.
- **Commande** : Les commandes passées par les clients
- **CommandeDetail** : Les lignes de détails des commandes
- **Produit** : Les produits vendus par la boutique

## Associations

- Client - Commande : **(1,n)**
    - Un client peut passer plusieurs commandes.
    - Une commande est passée par un seul client.

- Commande - CommandeDetail : **(1,n)**
    - Une commande peut contenir plusieurs lignes de détails.
    - Une ligne de détail est associée à une seule commande.

- CommandeDetail - Produit **(1,1)**
    - Une ligne de détail est associée à un seul produit.
    - Un produit peut être associé à plusieurs lignes de détails.

## Attributs

### Client

- id: int, PK
- nom: string, not null
- adresse: string

### Commande

- id: int, PK, not null
- date: date, not null
- id_client: int

### CommandeDetail

- id_commande: int, PK
- id_produit: int, PK
- quantite: int, not null, > 0

### Produit

- id: int, PK, not null
- label: string, not null, unique
- description: string, not null
- prix: float, not null, > 0

## Contraintes

### Intégrité référentielle

- Commande: id_client référence Client.id
- CommandeDetail: id_commande référence Commande.id, id_produit référence Produit.id

### Unicités

- Chaque client a un numéro unique.
- Chaque commande est identifiée par un numéro unique.
- Chaque produit est identifié par un numéro et un label unique.

### Non-nullité:

- Client: id, nom
- Commande: id, date, id_client
- CommandeDetail: id_commande, id_produit, quantite
- Produit: id, label, prix

### Contraintes de domaine

- Client: id > 0
- Commande: id > 0
- CommandeDetail: quantite > 0
- Produit: id > 0, prix > 0

## Diagramme ERD

![Diagramme Entités-Associations de la boutique](boutique-erd.svg)