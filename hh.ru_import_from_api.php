<!DOCTYPE html>
<html>
<head>
  <title>hh.ru. Импорт данных с API</title>
</head>
<body>

<?php 
  include('menu.php'); //можем исключать вообще это. Тут было мое меню
  //сўмтинг ин йўр айз
?>
<style>
  button{
    background-color: hsla(316, 69%, 41%, 1);
    color: white;
    padding: 10px;
    border-radius: 25px;
    border: 0px;
    box-shadow: green 0px 0px 20px;
    font-weight: bold;
    font-family: Arial, Helvetica, sans-serif;
  }
  input, select, option{
    background-color: black;
    font-family: "Bookman Old Style", sans-serif;
    color: yellow;
    font-size: 14px;
  }
  #searchline{
    margin-left: 50px;
  }
  tr, th, td, table{
    border: 1px solid black;
    border-collapse: collapse;
    padding: 5px;
  }
  tr:hover, tr:hover a{
    background-color: black;
    color: white;
    
    transition: 0.5s all;
  }
</style>
<div id="searchline">
<h1 id="hh">Импорт данных из hh.ru с помощью API</h1>
<label>Выбирайте город</label>
<select name="city" id="city">
  <option value="1">Москва</option>
  <option value="2">Санкт-Петербург</option>
  <option value="1753">Череповец</option>
  <option value="1345">Тобольск</option>
  <option value="58">Липецк</option>
  <option value="1937">Свободный</option>
  <option value="2788">Ургенч (Узбекистан)</option>
  <option value="2781">Бухара (Узбекистан)</option>
  <option value="2759">Ташкент (Узбекистан)</option>
</select><br><br>
<label>слово для поиска:</label>
<input placeholder="CSS, HTML, ..." id="text" type="text" autocomplete="off"><br><br>
<!--<label>Страница № (не объязательно)</label>
<input type="number" placeholder="1" id="number" autocomplete="off" title="Каждая страница включает в себя 100 результатов"><br><br>-->
<button id="button" onclick="getText();">Нажмите для получения данных с HH.ru</button>
<br><br><br>
</div>
<script>
  async function getText(){
    for (let d = 0; d < 100; d++) {
          console.log(d);
          /*var no = document.getElementById('number').value;
          if (!no) {
            no = 0;
          }*/
          var city = document.getElementById('city').selectedOptions[0].value;
          var lang = document.getElementById('text').value;
          //no changed to d
          var url='https://api.hh.ru/vacancies?text='+ lang + '&area=' + city + '&page=' + d + '&per_page=100';
          console.log(url);
          var req = await fetch(url);
          var response = await req.text();
          console.log(response);
          var obj=[];
          obj1 = await JSON.parse(response); 
          console.log(obj1);
          if (obj1.items.length ===0) {
            console.log('Нет вакансий!');
            
          }
          for (let i = 0; i < obj1.items.length; i++) {
            var tr = document.createElement('tr');
            var desc = obj1.items[i].name;
            console.log(vac_url);
            var salaryMin = function(){
              try{
                return obj1.items[i].salary.from;
              }catch(e){
                return "нет данных";
              }
            }
            var salaryMax = function(){
              try{
                return obj1.items[i].salary.to;
              }catch(e){
                return 'нет данных';
              }}
            var vac_url = obj1.items[i].alternate_url;
            tr.innerHTML = '<td style="max-width: 250px;">'+ desc +
            '</td><td>ЗП от: ' +  salaryMin() + '</td><td>ЗП до: ' 
            + salaryMax() + '</td><td><a href=\'' + vac_url + '\' target=\'blank\'>открыть</a></td>';
            document.body.appendChild(tr);
            document.getElementById('hh').innerHTML = 'Выборка: ' + lang + ', ' + document.getElementById('city').selectedOptions[0].innerHTML;
          }
      
    }
  } 
  
</script>
</body>
</html>
