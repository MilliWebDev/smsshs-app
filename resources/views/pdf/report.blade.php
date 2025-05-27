<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Bulletin de note</title>

      
        <!-- Scripts -->
        <style>

        
            html {
  font-family: sans-serif;
        }

    table {
        width:100%;
        table-layout: fixed;
  border-collapse: collapse;
  border: 2px solid rgb(200,200,200);
  letter-spacing: 1px;
  font-size: 0.8rem;
 
    }

    td, th {
  border: 1px solid rgb(190,190,190);
  padding: 10px 20px;

    }

    th {
  background-color: rgb(235,235,235);   
    }

    td {
  text-align: center;
    }

    tr:nth-child(even) td {
  background-color: rgb(250,250,250);
    }

    tr:nth-child(odd) td {
  background-color: rgb(245,245,245);
    }

    th:nth-child(4)  {
        overflow-wrap: break-word;
    }


    caption {
  padding: 10px;
    }

    h1{
        text-align: center;
        text-decoration: underline;
    }

        </style>
      
        
    </head>
    <body>
        <main>
            <h1>Bulletin du {{$semester->name}}</h1>
            <section id="information">
                <table >
                    <thead >
                        <tr >
                            <th scope="col" >Matières</th>
                            @foreach($assignments as $assignment)
                                <th scope="col" >{{$assignment->title}}</th>
                            @endforeach
                            <th scope="col" >Moyenne</th>
                            <th scope="col" >Appréciation</th>
                        </tr>
                    </thead>
                    <tbody>
                      @if($data)
                          @foreach($data as $subjectName => $subjectGrades)
                        <tr>
                           
                            <td >
                               <p>{{$subjectName}}</p>
                          </td>
                          @foreach($subjectGrades as $grade)
                            <td >
                                <p>{{$grade->score}}</p>
                            </td>
                            @endforeach
                            <td >
                                <p>{{$subjectGrades->avg('score')}}</p>
                            </td>
                            <td >
                                <p>{{$subjectGrades->first()->comment}}</p>
                            </td>

                        </tr>
                          @endforeach
                      @else
                            <tr>
                                <td colspan="7" >Aucun produit</td>
                            </tr>
                      @endif
                      </tbody>
                </table>
            </section>
        </main>
    </body>
</html>