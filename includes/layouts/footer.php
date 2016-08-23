        <nav class="navbar navbar-default navbar-fixed-bottom">
            <div class="container">
                    <p class="navbar-text pull-left">Site by Brett Sargeant</p>
                    <a class="navbar-btn btn btn-danger pull-right" href="https://www.youtube.com/channel/UCTYsKt1mWQbQIS9VpZVZ3Tg?sub_confirmation=1">Subscribe on Youtube</a>
            </div>
        </nav>

    </body>
</html>

<?php
  // 5. Close database connection
	if (isset($connection)) {
	  mysqli_close($connection);
	}
?>