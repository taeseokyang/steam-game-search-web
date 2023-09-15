<!DOCTYPE html>
<html lang="ko">

<head>
  <meta charset="UTF-8">
  <title>RecomBee</title>
  <link rel="stylesheet" href="recv.css">
</head>

<body style="background-color: rgb(240, 240, 240);">
  <header>
    <a href="#"><img src="images/logo.png" alt=""></a>
    <h1 class="title"><a href="html.html">RECOM - - - BEE</a></h1>
  </header>
  <div class="box">

  </div>
  <div id="main">
    <div id="top">
      <?php 
          echo $_COOKIE["tagstr"];
      ?>
    </div>
    <div id="resurt">
    <?php 

      echo "<table class='type10'>";
      echo "<thead>";
      echo "<th id='cnt'>#</th>";
      echo "<th id='img'>GAME</th>";
      echo "<th id='game'></th>";
      echo "<th id='score'>SCORE</th>";
      echo "<th id='cost'>COST</th>";
      echo "<th id='link'>LINK</th>";
      echo "</thead>";
      echo "<tbody>";
      $con=mysqli_connect("127.0.0.1","root","password","myweb");
      $rq = $_COOKIE['rq']."ORDER BY gpa DESC limit ".(($_POST['submit']-1)*10).",10;";
      $ret = mysqli_query($con,$rq);
      $cnt = ($_POST['submit']-1)*10+1;
      while($row = mysqli_fetch_assoc($ret)){
        if($cnt%2==0){
          echo "<tr>";
        echo "<td class='even'>&nbsp".$cnt++."</td>";
        echo "<td class='even'><span></span></td>";
        echo "<td class='even'>".$row['name']."</td>";
        echo "<td class='even'>".$row['gpa']."점</td>";
        if($row['initialprice']==0){
          echo "<td class='even'>Free</td>";
        }else{
          echo "<td class='even'>$".$row['initialprice']."</td>";
        }
        
        echo "<td class='even'><a href='https://store.steampowered.com/app/".$row['appid']."/'>https://store.steampowered.com/app/".$row['appid']."</a></td>";
        echo "</tr>";
        }else{
          echo "<tr>";
        echo "<td>&nbsp".$cnt++."</td>";
        echo "<td><span></span></td>";
        echo "<td>".$row['name']."</td>";
        echo "<td>".$row['gpa']."점</td>";
        if($row['initialprice']==0){
          echo "<td>Free</td>";
        }else{
          echo "<td>$".$row['initialprice']."</td>";
        }
        echo "<td><a href='https://store.steampowered.com/app/".$row['appid']."/'>https://store.steampowered.com/app/".$row['appid']."</a></td>";
        echo "</tr>";
        }
      }
      echo "</tbody>";
      echo "<tfoot>";
      echo "<tr>";
      echo "<td colspan='6'>";

      echo "<form name='form' METHOD='post' action='receive_2.php'>";

      for($i=1;$i<=$_COOKIE['page_num'];$i++){
        echo "<input type = 'submit' name='submit' value = '".$i."'/>";
      }
      echo "</form>";
      echo "</td>";
      echo "</tr>";
      echo "</tfoot>";
      echo "</table>";
      mysqli_close($con);
    ?>
    </div>
  </div>
  <footer>
  </footer>
</body>
</html>