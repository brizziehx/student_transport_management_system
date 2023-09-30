<header>
    <h2>School Transportation Management System</h2>
    <!-- <h2><?=$greetings?><span style="text-transform:capitalize"><?=$_SESSION['admin']?></span>!</h2> -->
    <div class="user">
        <span class="username"><?php echo $row['firstname'].' '.$row['lastname'] ?><span class="utype"><?=$row['usertype']?></span></span>
        <img src="../uploads/<?=$row['image']?>" >
    </div>
</header>