Links utilizados pelo juiz
=========
----
Acessar informações da próxima submissão
----
```
 [host]/index.php/judge/get-submission
```

Parâmetros por POST
```
 key=[key]
```
Formato do retorno:
```
 submission_id
 submission_language (1=C, 2=C++)
 problem_id
 problem_version
 problem_timelimit (milissegundos)
```
-----
Acessar zip com todos os casos de teste do problema
-----
```
 [host]/index.php/judge/get-cases/
```
Parâmetros por POST: 
```
 key=[key]&problem=[problem_id]
```

----
Acessar código fonte da submissão
----
```
 [host]/index.php/judge/get-source/
```
Parâmetros por POST: 
```
 key=[key]&submission=[submission_id]
```
----
Enviar resultado da submissão
----
```
 [host]/index.php/judge/set-submission
```
Parâmetros por POST: 
```
 key=[key]&submission=[submission_id]&result=[result]&time=[time]
```
Onde result, pode ser:
```
 1 - Accepted
 2 - Presentation Error
 3 - Wrong Answer
 4 - Compile Error
 5 - Runtime Error
 6 - Time Limit
```

