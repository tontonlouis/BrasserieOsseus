# BrasserieOsseuse
Brasserie Osseuse 


 ------------ -----------------------------------------------------------------
 Type           Description                                                     
 ------------ -----------------------------------------------------------------
      ManyToOne    Each Order relates to (has) one User.                            
                   Each User can relate to (can have) many Order objects
    
      OneToMany    Each Order can relate to (can have) many User objects.           
                   Each User relates to (has) one Order
    
      ManyToMany   Each Order can relate to (can have) many User objects.           
                   Each User can also relate to (can also have) many Order objects
    
      OneToOne     Each Order relates to (has) exactly one User.                    
                   Each User also relates to (has) exactly one Order.
 ------------ -----------------------------------------------------------------
 
 Français
 ------------ -----------------------------------------------------------------
 Type           Description                                                     
 ------------ -----------------------------------------------------------------
       ManyToOne       Chaque commande concerne un utilisateur.
                        Chaque utilisateur peut avoir une relation avec plusieurs objets Order.
                        
       OneToMany       Chaque commande peut concerner de nombreux objets utilisateur.
                        Chaque utilisateur se rapporte à une commande.       
        
       ManyToMany      Chaque commande peut concerner de nombreux objets utilisateur.
                        Chaque utilisateur peut également se rapporter à de nombreux objets Order.
        
       OneToOne        Chaque commande concerne exactement un utilisateur.
                        Chaque utilisateur se rapporte également à exactement une commande.
------------ -----------------------------------------------------------------

                                                                                                                                              
  An exception occurred while executing 'INSERT INTO order_product (quantity, order_id, product_id) VALUES (?, ?, ?)' with params [6, 2, 6]:  
                                                                                                                                              
  SQLSTATE[23000]: Integrity constraint violation: 1062 Duplicata du champ '6' pour la clef 'UNIQ_2530ADE64584665A'                           
                                                                                                                                              

In PDOStatement.php line 119:
                                                                                                                     
  SQLSTATE[23000]: Integrity constraint violation: 1062 Duplicata du champ '6' pour la clef 'UNIQ_2530ADE64584665A'  
                                                                                                                     

In PDOStatement.php line 117:
                                                                                                                     
  SQLSTATE[23000]: Integrity constraint violation: 1062 Duplicata du champ '6' pour la clef 'UNIQ_2530ADE64584665A'  
        