<?php
if (!isset($_REQUEST['id_ordine'])) exit('die');
include 'inc_config.php';

$db->query("SELECT * FROM bag_ordini WHERE id = " . $_REQUEST['id_ordine']);

$ordine = $db->single();

$db->query("SELECT * 
                 FROM 
                 bag_det_ord
                 INNER JOIN bag_prodotti ON bag_prodotti.id = bag_det_ord.id_articolo
                 WHERE id_ordine='" . $_REQUEST['id_ordine'] . "'
                 ");

$articoli = $db->resultset();


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
     <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
     <title>Ordine</title>
</head>

<body style="margin: 0; padding: 0; background-color: #f3f1f1; font-family: Calibri, Arial, Helvetica, sans-serif; font-size: 14px; line-height: 1.4; color: #333;">
     <!-- Wrapper Table -->
     <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color: #f3f1f1;">
          <tr>
               <td align="center" style="padding: 20px 0;">
                    <!-- Main Content Table -->
                    <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="600" style="max-width: 600px; background-color: #ffffff; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">

                         <!-- Header -->
                         <tr>
                              <td style="padding: 30px 40px 20px; text-align: center; background-color: #ffffff;">
                                   <h1 style="margin: 0; font-size: 28px; color: #0a0c09; font-weight: bold;"><?php echo $lang['conferma_ordine']; ?> numero SK<?php echo $_REQUEST['id_ordine']; ?></h1>
                                   <img src="<?php echo BASE_URL; ?>img/logo1.png" alt="Logo" style="width: 140px; height: auto; margin: 20px 0; border: 0;" />
                              </td>
                         </tr>

                         <!-- Dettagli Ordine -->
                         <tr>
                              <td style="padding: 0 40px 30px;">
                                   <p style="margin: 0 0 20px; font-size: 16px; color: #333;">
                                        Gentile Cliente,<br />
                                        la ringraziamo per aver ordinato i nostri prodotti.<br />
                                        Di seguito il dettaglio dell'ordine:
                                   </p>
                                   <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color: #f8f9fa; border-radius: 6px; border: 1px solid #e9ecef;">
                                        <tr>
                                             <td style="padding: 20px; font-size: 15px;">
                                                  <strong>ID ORDINE:</strong> SK<?php echo $_REQUEST['id_ordine']; ?><br />
                                                  <strong>DATA ORDINE:</strong> <?php $data_ordine = date('d/m/Y', strtotime($ordine['data']));
                                                                                echo $data_ordine; ?><br /><br />

                                                  <strong>L'ordine verrà spedito con:</strong><br />
                                                  <?php echo $ordine['tipo_spedi'] . '&nbsp;&nbsp;&euro;' . $ordine['spese_spe']; ?><br /><br />
                                                  <strong>Hai scelto di pagare con:</strong><br />
                                                  <?php echo $ordine['tipo_pagam'] . '&nbsp;&nbsp;&euro;' . $ordine['spese_pag']; ?>
                                                  <?php if ($ordine['tipo_pagam'] == 'Carta di Credito') { ?>
                                                       <br />CARTA DI CREDITO<br />
                                                       Se ancora non hai effettuato il pagamento, puoi sempre farlo dalla tua <a href="<?php echo BASE_URL; ?>ordini.php" style="color: #19a9e5; text-decoration: none;">area privata, nella sezione "I tuoi ordini"</a>.
                                                  <?php } ?>
                                             </td>
                                        </tr>
                                   </table>

                                   <?php if ($ordine['tipo_pagam'] == 'Bonifico Bancario') { ?>
                                        <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%" style="margin-top: 20px; background-color: #fff3cd; border: 2px dotted #d72c38; border-radius: 6px;">
                                             <tr>
                                                  <td style="padding: 15px; color: #856404;">
                                                       <?php echo $lang['testo_pag_bon']; ?>
                                                  </td>
                                             </tr>
                                        </table>
                                   <?php } ?>
                              </td>
                         </tr>

                         <!-- Tabella Prodotti -->
                         <tr>
                              <td style="padding: 0 40px 30px;">
                                   <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%">
                                        <tr>
                                             <td style="background-color: #009392; padding: 15px; border-radius: 6px 6px 0 0; text-align: center;">
                                                  <h2 style="margin: 0; font-size: 18px; color: #ffffff; font-weight: bold;">Dettaglio Prodotti</h2>
                                             </td>
                                        </tr>
                                        <tr>
                                             <td style="background-color: #ffffff; border: 1px solid #dee2e6; border-top: 0;">
                                                  <!-- Header Tabella -->
                                                  <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%" style="border-collapse: collapse;">
                                                       <tr style="background-color: #e9ecef;">
                                                            <th style="padding: 12px 8px; font-size: 14px; font-weight: bold; text-align: left; width: 30%; color: #495057;"> <?= $lang['img']; ?></th>
                                                            <th style="padding: 12px 8px; font-size: 14px; font-weight: bold; text-align: left; width: 35%; color: #495057;"> <?= $lang['nome']; ?></th>
                                                            <th style="padding: 12px 8px; font-size: 14px; font-weight: bold; text-align: center; width: 10%; color: #495057;"> <?= $lang['prezzo']; ?></th>
                                                            <th style="padding: 12px 8px; font-size: 14px; font-weight: bold; text-align: center; width: 10%; color: #495057;"> <?= $lang['quantita']; ?></th>
                                                            <th style="padding: 12px 8px; font-size: 14px; font-weight: bold; text-align: right; width: 15%; color: #495057;"> <?= $lang['totale']; ?></th>
                                                       </tr>
                                                       <?php

                                                       $totale_articoli = 0;
                                                       foreach ($articoli as $articolo) {
                                                            $totale_articoli += $articolo['prezzo'] * $articolo['qta'];
                                                       ?>
                                                            <tr style="border-bottom: 1px solid #dee2e6;">
                                                                 <td style="padding: 15px 8px; vertical-align: top;">
                                                                      <?php if (!empty($articolo['immagine'])) { ?>
                                                                           <img src="<?php echo BASE_URL; ?>upload/prodotti/<?php echo $articolo['immagine']; ?>" alt="<?php echo $articolo['nome_' . $lng]; ?>" width="80" height="80" style="width: 80px !important; height: 80px !important; display: block; border: 0; object-fit: cover;" />
                                                                      <?php } ?>
                                                                 </td>                                                                 
                                                                 <td style="padding: 15px 8px; text-align: left;"><strong style="color: #322a7c; font-size: 16px;"><?php echo $articolo['nome_' . $lng]; ?></strong></td>
                                                                 <td style="padding: 15px 8px; text-align: center; font-weight: bold;">&euro;<?php echo number_format($articolo['prezzo'], 2, ',', '.'); ?></td>
                                                                 <td style="padding: 15px 8px; text-align: center;"><?php echo $articolo['qta']; ?></td>
                                                                 <td style="padding: 15px 8px; text-align: right; font-weight: bold; color: #322a7c;">&euro;<?php echo number_format(($articolo['prezzo'] * $articolo['qta']), 2, ',', '.'); ?></td>

                                                            </tr>
                                                       <?php } ?>
                                                  </table>
                                             </td>
                                        </tr>
                                   </table>

                                   <!-- Totale -->
                                   <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%" style="margin-top: 20px; background-color: #f8f9fa; border-radius: 6px; border: 1px solid #dee2e6;">
                                        <tr>
                                             <td style="padding: 20px;">
                                                  <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%">
                                                       <tr>
                                                            <td style="padding: 8px 0; width: 70%; text-align: right; font-weight: bold;">Imponibile:</td>
                                                            <td style="padding: 8px 0; width: 30%; text-align: right;">&euro;<?php echo number_format($totale_articoli, 2, ',', '.'); ?></td>
                                                       </tr>
                                                       <tr>
                                                            <td style="padding: 8px 0; width: 70%; text-align: right; font-weight: bold;">Iva (22%):</td>
                                                            <td style="padding: 8px 0; width: 30%; text-align: right;">&euro;<?php echo number_format(($totale_articoli / 100 * 22), 2, ',', '.'); ?></td>
                                                       </tr>
                                                       <tr>
                                                            <td style="padding: 8px 0; width: 70%; text-align: right; font-weight: bold;">Spese di spedizione:</td>
                                                            <td style="padding: 8px 0; width: 30%; text-align: right;">&euro;<?php echo number_format($ordine['spese_spe'], 2, ',', '.'); ?></td>
                                                       </tr>
                                                       <tr>
                                                            <td style="padding: 8px 0; width: 70%; text-align: right; font-weight: bold;">Spese di pagamento:</td>
                                                            <td style="padding: 8px 0; width: 30%; text-align: right;">&euro;<?php echo number_format($ordine['spese_pag'], 2, ',', '.'); ?></td>
                                                       </tr>
                                                       <tr style="background-color: #ffffff; border-top: 2px solid #009392;">
                                                            <td style="padding: 15px 0; width: 70%; text-align: right; font-size: 18px; font-weight: bold; color: #322a7c;">TOTALE:</td>
                                                            <td style="padding: 15px 0; width: 30%; text-align: right; font-size: 20px; font-weight: bold; color: #009392;">&euro;<?php echo number_format(($totale_articoli + ($totale_articoli / 100 * 22) + $ordine['spese_spe'] + $ordine['spese_pag']), 2, ',', '.'); ?></td>
                                                       </tr>
                                                  </table>
                                             </td>
                                        </tr>
                                   </table>
                              </td>
                         </tr>

                         <!-- Footer -->
                         <tr>
                              <td style="padding: 30px 40px; text-align: center; background-color: #f8f9fa; border-top: 1px solid #dee2e6;">
                                   <img src="<?php echo BASE_URL; ?>img/logo1.png" alt="Logo" style="width: 230px; height: auto; margin-bottom: 15px; border: 0;" />
                                   <p style="margin: 0 0 10px; font-size: 14px; color: #666;">
                                        Sito Internet: <a href="https://www.sekurbox.com" style="color: #19a9e5; text-decoration: none;">sekurbox.com</a><br />
                                        Email: <a href="mailto:info@sekurbox.com" style="color: #19a9e5; text-decoration: none;">info@sekurbox.com</a>
                                   </p>
                              </td>
                         </tr>
                    </table>
               </td>
          </tr>
     </table>
</body>

</html>