<!DOCTYPE html>
<html lang="en-US">
    <head>
        <meta charset="UTF-8">
        <title>Elastic Search</title>
        <script>
                let request = new XMLHttpRequest(); 
                request.open('GET', 'php/searching.php');
                request.setRequestHeader('Content-Type', 'application/json; charset=UTF-8');
                request.onreadystatechange = function() {
                    if (request.readyState === 4 && request.status == 200) {
                        let json = eval('(' + request.responseText + ')');
                        let jsonLength = json.length;
                        let allData = JSON.parse(request.responseText);
                        $i = 0;
                        for ($i =0; $i < jsonLength; $i++) {
                            document.getElementById('results').innerHTML += allData[$i].name + ', ';
                            document.getElementById('results').innerHTML += allData[$i].city + ', ';
                            document.getElementById('results').innerHTML += '<br>';
                        }
                    }
                }
                request.send();

                function filter() {
                    let city = document.querySelector("input[name='city']").value
                    let country = document.querySelector("input[name='country']").value
                    let route = 'php/searching.php';
                    let dataString = 'city=' + city;

                    let request = new XMLHttpRequest(); 
                    request.onreadystatechange = function() {
                        if (request.readyState === 4 && request.status == 200) {
                            alert('Zoekfunctie is doorgegeven! Cache is ook aangemaakt!');
                        }
                    }
                    request.open('POST', route);
                    request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                    request.send(dataString);

                    

                };
        </script>
    </head>
    <body>
        <div id="container">
            <div id="filter">
                <fieldset><legend>Filter:</legend>
                    <label>City: <input type="text" name="city"></label>
                    <label>Country: <input type="text" name="country"></label>
                    <button onclick="filter()">Filter</button>
                </fieldset>
            </div>
            <div id="results">
            </div>
        </div>
    </body>
</html><?php
?>