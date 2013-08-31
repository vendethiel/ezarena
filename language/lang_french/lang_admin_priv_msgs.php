<?php
/***************************************************************************
*                            $RCSfile: lang_admin_priv_msgs.php,v $
*                            -------------------
*   begin                : Tue January 20 2002
*   copyright            : (C) 2002-2003 Nivisec.com
*   email                : support@nivisec.com
*
*   $Id: lang_admin_priv_msgs.php,v 1.1 2005/07/21 15:49:49 Nivisec Exp $
*
*
***************************************************************************/

/***************************************************************************
*
*   This program is free software; you can redistribute it and/or modify
*   it under the terms of the GNU General Public License as published by
*   the Free Software Foundation; either version 2 of the License, or
*   (at your option) any later version.
*
***************************************************************************/


/* Added in 1.6.0 */
$lang['PM_View_Type'] = 'Type de vue des MP';
$lang['Show_IP'] = 'Montrer l\'adresse IP';
$lang['Rows_Per_Page'] = 'Lignes par page';
$lang['Archive_Feature'] = 'Caractéristiques de l\'archive';
$lang['Inline'] = 'Inline';
$lang['Pop_up'] = 'Pop-up';
$lang['Current'] = 'Actuel';
$lang['Rows_Plus_5'] = 'Ajouter 5 lignes';
$lang['Rows_Minus_5'] = 'Enlever 5 lignes';
$lang['Enable'] = 'Activé';
$lang['Disable'] = 'Désactivé';
$lang['Inserted_Default_Value'] = 'L\'item %s de la configuration n\'existe pas, une valeur par défaut a été insérée<br />'; // %s = config name
$lang['Updated_Config'] = 'Item %s de la configuration actualisé<br />'; // %s = config item
$lang['Archive_Table_Inserted'] = 'La table des archives n\'existe pas, elle vient d\'être créée<br />';
$lang['Switch_Normal'] = 'Changer pour le mode normal';
$lang['Switch_Archive'] = 'Changer pour le mode archive';

/* General */
$lang['Deleted_Message'] = 'Message privé effacé - %s <br />'; // %s = PM title
$lang['Archived_Message'] = 'Message privé archivé - %s <br />'; // %s = PM title
$lang['Archived_Message_No_Delete'] = 'Vous ne pouvez pas effacer %s, il a été marqué \'archivé\' aussi <br />'; // %s = PM title
$lang['Private_Messages'] = 'Messages Privés';
$lang['Private_Messages_Archive'] = 'Archive des Messages Privés';
$lang['Archive'] = 'Archive';
$lang['To'] = 'Pour';
$lang['Subject'] = 'Sujet';
$lang['Sent_Date'] = 'Date d\'envoi';
$lang['Delete'] = 'Effacer';
$lang['From'] = 'De';
$lang['Sort'] = 'Ordonner';
$lang['Filter_By'] = 'Filtre par';
$lang['PM_Type'] = 'Type de MP';
$lang['Status'] = 'Statuts';
$lang['No_PMS'] = 'Aucun Message Privé avec vos critères de tri à montrer';
$lang['Archive_Desc'] = 'Les Messages Privés choisis pour archivés sont listés ici. Les Utilisateurs ne peuvent plus y accéder (envoyer et recevoir), mais vous pouvez les voir ou les effacer à n\'importe quel moment.';
$lang['Normal_Desc'] = 'Tous les Messages Privés du forum peuvent être contrôlés ici. Vous pouvez lire et choisir de les effacer ou de les archiver (maintenir, mais les utilisateurs ne peuvent plus les voir) tous les messages également.';
$lang['Version'] = 'Version';
$lang['Remove_Old'] = 'MPs Orphelins:</a> <span class="gensmall">Les Utilisateurs qui n\'existe plus peuvent avoir laisser des MPs derrière eux, ceci les supprimera.</span>';
$lang['Remove_Sent'] = 'MPs envoyés:</a> <span class="gensmall">Les MPs dans la boîte des messages envoyés sont seulement des copies des messages envoyés, excepté le fait qu\'ils ont été attribués à l\'expéditeur du message après que l\'utilisateur ayant reçu le Message Privé l\'ait lu. Ce n\'est pas réellement nécessaire.</span>';
$lang['Affected_Rows'] = '%d entrées connues supprimées<br>';
$lang['Removed_Old'] = 'Tous les Messages Privés Orphelins ont été supprimés<br>';
$lang['Removed_Sent'] = 'Tous les Messages Privés envoyés on été supprimés<br>';
$lang['Utilities'] = 'Utilitaires de Suppression Massive';
$lang['Nivisec_Com'] = 'Nivisec.com';

/* PM Types */
$lang['PM_-1'] = 'Tous les types'; //PRIVMSGS_ALL_MAIL = -1
$lang['PM_0'] = 'MPs Lus'; //PRIVMSGS_READ_MAIL = 0
$lang['PM_1'] = 'Nouveaux MPs'; //PRIVMSGS_NEW_MAIL = 1
$lang['PM_2'] = 'MPs Envoyés'; //PRIVMSGS_SENT_MAIL = 2
$lang['PM_3'] = 'MPs Sauvegardés (Dedans)'; //PRIVMSGS_SAVED_IN_MAIL = 3
$lang['PM_4'] = 'MPs Guardadas (Dehors)'; //PRIVMSGS_SAVED_OUT_MAIL = 4
$lang['PM_5'] = 'MPs Non-Lus'; //PRIVMSGS_UNREAD_MAIL = 5

/* Errors */
$lang['Error_Other_Table'] = 'Erreur de demande dans la table demandée.';
$lang['Error_Posts_Text_Table'] = 'Erreur de demande dans la table \'texte\' des Messages Privés.';
$lang['Error_Posts_Table'] = 'Erreur de demande dans la table des Messages Privés.';
$lang['Error_Posts_Archive_Table'] = 'Erreur de demande dans la tables des \'archives\' des Messages Privés.';
$lang['No_Message_ID'] = 'Aucune ID de message n\'a été spécifiée.';


/*Special Cases, Do not bother to change for another language */
$lang['ASC'] = $lang['Sort_Ascending'];
$lang['DESC'] = $lang['Sort_Descending'];
$lang['privmsgs_date'] = $lang['Sent_Date'];
$lang['privmsgs_subject'] = $lang['Subject'];
$lang['privmsgs_from_userid'] = $lang['From'];
$lang['privmsgs_to_userid'] = $lang['To'];
$lang['privmsgs_type'] = $lang['PM_Type'];

?>
