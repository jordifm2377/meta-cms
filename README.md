# meta-cms

Notes de recordatori:

-Hi hauria d'haver 3 tipus de entitats:

  1) Entitat amb identiat propia, vindria a ser una knowledge area d'integrity (Drug)
    -Quan s'esta insertant o afegint una entitat principal, no es pot afegir una altra entitat principal dins el mateix formulari. Sempre hi haura un manteniment per separat.
    -L'estat per defecte, sera (Pending) encara que sera visible per un altre usuari (sempre indicant l'estat!!!)
  2) Entitat complementaria, podria o no tenir detall propi. (Disease)
    -Semblantment a les princpials, tindran un manteniment propi, i no es poden afegir en un mateix formulari 2 entitats complementaries o 1 entitat complementaria i 1 principal
    -L'estat per defecte, sera (Pending) encara que sera visible per un altre usuari (sempre indicant l'estat!!!)
  3) Entitat de relacio, no tenen manteniment propi, pero poden tenir estat (Pending) per defecte
    -Aquestes entitats es creen automaticament fent servir la logica implementada a la UI.
    -Es pot canviar l'entitat d'estat i es pot borrar
    -Sempre seran entitats que es crearan entre entitats tipus 1-1 o 1-2 ????
    -S'ha d'incloure l'ID en el json ???


-Com guardar una entitat pendent d'aprovacio ?

  La UI hauria de ser capaç de generar un JSON amb l'informacio de l'entitat inserida o editada. Sobretot en els casos de "delete" de relacions i especialment en relacions que son noves i l'usuari no ha guardar i les esborra abans de guardar --> aquesta informacio no s'hauria d'enviar al servei.
  Si s'intenta insertar una entitat mentre s'esta insertant/editant una altra entitat, s'ha de començar un nou manteniment i un cop finalitzat, recarregar aquella part o fer l'associacio directa.
  La UI ha de generar com a part del JSON a enviar, informacio suficient pq el servei sapiga que ha de fer amb cada part del JSON.
  Quan el servei rebi el JSON, ha de validar que hi ha totes les dades necessaries, es pot utilitzar una crida per obtenir les metadades i comparar.
  El servei ha d'insertar totes les entitats en status pendent. Les entitats en estat Pending, MAI poden ser accedides fora del CMS!!!
  NOTA: Es podrien tenir 2 entorns de dades ??? tal com el MACBA ? ... l'entorn de PROD on totes les dades estan aprovades i l'entorn de pendents on hi ha la mateixa informacio que a PROD + dades pendents d'aprovar
    -Que s'ha de fer amb les dades de PROD que es volen esborrar ?!?!
    -Com fer el tracking dels canvis ???
    -Si es fa servir aquest metode, la UI nomes hauria d'accedir a l'entorn de PENDING!

  
