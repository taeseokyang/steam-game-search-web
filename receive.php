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
      $tagstr = "";
      for($k=1;$k<=6;$k++){
        $tags = $_POST['rd'.$k];
        if($k==4||$k==5){
          for($i=0;$i<count($_POST['rd'.$k]);$i++){
            $tagstr = $tagstr."<span>".$tags[$i]."</span>";
            echo "<span>".$tags[$i]."</span>";
          }
        }else{
          $tagstr = $tagstr."<span>".$tags."</span>";
          echo "<span>".$tags."</span>";
        }
      }
      ?>
    </div>
    <div id="resurt">
    <?php 
      $rq = "tags like '%".$_POST['rd2']."%' and ";
      if($_POST['rd3']=="Korean")
        $rq = $rq."languages like '%".$_POST['rd3']."%' and ";
      $t = $_POST['rd4'];
      for($i=0;$i<count($_POST['rd4']);$i++){
        $rq = $rq."tags like '%".$t[$i]."%' ";
        $rq = $rq."and ";
      }
      $t = $_POST['rd5'];
      for($i=0;$i<count($_POST['rd5']);$i++){
          $rq = $rq."tags like '%".$t[$i]."%' ";
        if($i==(count($_POST['rd5'])-1)){

          $ch_page = $rq; //앞뒤 제거 보관
          $rq_cnt = 'select count(*) as cnt from stm_game where '.$rq.'ORDER BY gpa DESC limit 100;'; //개수
          $rq = 'select * from stm_game where '.$rq."ORDER BY gpa DESC limit 10;";
          $ch_page = 'select * from stm_game where '.$ch_page;
        }else{
          $rq = $rq."and ";
        }
      }
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
      // $db_host="127.0.0.1";
      // $db_user="root";
      // $db_password="1234";
      // $db_name="webdb";
      $con=mysqli_connect("127.0.0.1","root","password","myweb");

      $ret = mysqli_query($con,$rq_cnt);
      $row = mysqli_fetch_assoc($ret);
      $row_cnt = $row['cnt'];

      $ret = mysqli_query($con,$rq);
      $cnt = 1;
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

      $page_num = $row_cnt/10;
      if($row_cnt%10 != 0){
        $page_num++;
      }
      setcookie("rq","",0);
      setcookie("tagstr","",0);
      setcookie("page_num","",0);
      setcookie("rq",$ch_page);
      setcookie("tagstr",$tagstr);
      setcookie("page_num",$page_num);
      for($i=1;$i<=$page_num;$i++){
        echo "<input type = 'submit' name='submit' value = '".$i."'/>";
      }
      // $ch_page = $ch_page."ORDER BY gpa DESC limit ".(($i-1)*10).",10;"; //DB쿼리문
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