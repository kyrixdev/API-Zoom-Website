<?php
require_once 'config.php'; 
include('header.php');
?>

<div class="text-left justify-center flex py-5">
  <form action="create-meeting.php">
    <label for="mname" class="pr-2 text-teal-700 text-lg font-medium">Nom de session:</label>
    <input type="text" id="mname" name="mname" value="" class="border-2 border-gray-500"><br><br>
    <label for="mdes" class="pr-2 text-teal-700 text-lg font-medium">Description:</label>
    <input type="text" id="mdes" name="mdes" value="" class="border-2 border-gray-500"><br><br>
    <label for="mtime" class="pr-24 text-teal-700 text-lg font-medium">Durée <span class="text-gray-500">(m):</span></label>
    <input type="text" id="mtime" name="mtime" value="30" class="border-2 border-gray-500"><br><br>
    <label for="mdate" class="pr-6 text-teal-700 text-lg font-medium">Temp de session:</label>
    <input type="date" id="mdate" name="mdate" class="border-2 border-gray-500"><br><br>
    <label for="mhour" class="pr-10 text-teal-700 text-lg font-medium">Select hour:</label>
    <input type="time" id="mhour" name="mhour" class="border-2 border-gray-500"><br><br>
    <input type="submit" value="Submit" class="bg-gray-900 hover:bg-gray-900 text-white font-bold py-2 px-4 rounded-full">
  </form> 
</div>






</body>
</html>