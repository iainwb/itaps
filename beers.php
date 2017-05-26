
<?php
   include ('assets/inc/func.inc');
   require_once ('connections/itaps_conn.php');
   
   //include config
   require_once('assets/inc/config.php'); 
   
   // define variables and set to empty/placeholder values
   
   $abv = '';
   
   // Pull beer data
   
   $query_beerlist = "SELECT
beers.beer_id,
beers.beer_name,
bjcp_styles.style_name,
bjcp_styles.style_number,
beers.og,
beers.fg,
beers.ibu,
beers.srm_decimal,
beers.srm_value_fk,
srm.color_name,
srm.hex_color,
beers.note
FROM
srm
JOIN beers
ON srm.srm_value = beers.srm_value_fk 
JOIN bjcp_styles
ON bjcp_styles.style_number = beers.style_number_fk";
   $beerlist = $conn->query($query_beerlist);
   $row_beerlist = $beerlist->fetch(PDO::FETCH_ASSOC);
   
     
     //define page title
     $title = 'Beer List';
     
     //include html header template
     require('assets/inc/html-header.php');
   ?>
<body>
      <!-- Modal HTML Delete Beer -->
      <div id="beer-process-delete" class="modal fade">
         <div class="modal-dialog">
            <div class="modal-content">
               <div class="modal-header">
                  <h4 class="modal-title">Confirmation</h4>
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
               </div>
               <div class="modal-body">
                  <p>Do you want to delete this beer?</p>
                  <p class="text-warning"><small>This change cannot be undone.</small></p>
               </div>
               <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                  <button type="button" class="btn btn-primary" onclick="submitBeerProcess()">Delete</button>
               </div>
            </div>
         </div>
      </div>
      <!-- Modal HTML Edit Beer -->
      <div id="beer-process-edit" class="modal fade">
         <div class="modal-dialog">
            <div class="modal-content">
               <div class="modal-header">
                  <h4 class="modal-title">Confirmation</h4>
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
               </div>
               <div class="modal-body">
                  <p>Do you want to edit this beer?</p>
                  <p class="text-warning"><small>This change cannot be undone.</small></p>
               </div>
               <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                  <button type="button" class="btn btn-primary" onclick=" submitBeerProcess()">Edit</button>
               </div>
            </div>
         </div>
      </div>
      <?php include("assets/inc/navbar-header.inc"); ?>
      <div class="container">
      <div class="page-title">
         <h1>Beer List</h1>
         <?php 
            if (!empty($feedback))
            echo'<div class="alert alert-'.$feedbackType.' " role="alert">'.$feedback.'</div>';
            ?>
      </div>
      <form id="beer-edit" class="beer-edit" action="beers-edit.php" method="post">
         <div class="info">
            <?php do { 
               $beer_id = $row_beerlist['beer_id'];
               $beer_name = $row_beerlist['beer_name'];
               $style = $row_beerlist['style_name'];
               $style_number = $row_beerlist['style_number'];
               $og = $row_beerlist['og'];
               $fg = $row_beerlist['fg'];
               $ibu = $row_beerlist['ibu'];
               $color_name = $row_beerlist['color_name'];
               $srm_decimal = $row_beerlist['srm_decimal'];
               $note = $row_beerlist['note'];
               $gubu = round($ibu/(($og-1)*1000),2);
               $ibuImg = (round($ibu/120,2)*100);
               $abvImg = (round(abv($og, $fg, $abv, $digits = 2)/20,2)*100);
               ?>
            <div class="row">
               <div class="col name"><?php echo $beer_name; ?><br/><?php echo $style; ?></div>
            </div>
            <div class="row">
               <div class="col-md-2 hidden-sm-down og">OG:&nbsp;<?php echo $og; ?></div>
               <div class="col-md-2 hidden-sm-down fg">FG:&nbsp;<?php echo $fg; ?></div>
               <div class="col-md-5 hidden-sm-down abv">ABV:&nbsp;<?php echo abv($og, $fg, $abv, $digits = 2); ?>%</div>
               <div class="col-md-3 edit"><button type="button" class="beer-process btn btn-outline-success"  data-toggle="modal" data-target="#beer-process-edit" data-beer_id="<?php echo $beer_id ?>" data-action="edit"><span class="fa fa-pencil-square-o fa-lg" aria-hidden="true"></span>Edit Beer</button></div>
            </div>
            <div class="row">
               <div class="col-md-2 hidden-sm-down ibu">IBU:&nbsp;<?php echo $ibu; ?></div>
               <div class="col-md-2 hidden-sm-down srm">SRM:&nbsp;<?php echo $srm_decimal; ?></div>
               <div class="col-md-5 hidden-sm-down note">Note:&nbsp;<?php echo $note; ?></div>
               <div class="col-md-3 delete"><button type="button" class="beer-process btn btn-outline-danger"  data-toggle="modal" data-target="#beer-process-delete" data-beer_id="<?php echo $beer_id ?>" data-action="delete"><span class="fa fa-trash-o fa-lg" aria-hidden="true"></span>Delete Beer</button></div>
            </div>
            <?php } while ($row_beerlist = $beerlist->fetch(PDO::FETCH_ASSOC)); ?>
         </div>
      </form>
      <!-- /container -->
      <!-- Hidden Form to Process Keg actions -->
      <form id="beer-process" class="beer-process" action="beers-edit.php" method="post">
         <input type="hidden" class="action" name="action" value="">
         <input type="hidden" class="beer-id" name="beer_id" value="">
      </form>
      <form class="hidden" id="beer-new" action="beers-edit.php" method="post">
         <input type="hidden" name="action" value="new">
         <input type="hidden" name="beer_id" value="">
      </form>
  <?php    //include html footer template
      require('assets/inc/html-footer.php');   
      ?>
      
      </body>
   </html>