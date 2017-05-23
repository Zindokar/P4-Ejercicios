fibo(0, 0).
fibo(1, 1).
fibo(X, Y) :-   X > 1,
                X2 is X - 2,
                fibo(X2, Y2),
                X1 is X - 1,
                fibo(X1, Y1),
                Y is Y1 + Y2.


expo(_, 0, 1).
expo(B,1,B).
expo(B,N,R):-   N > 1,
                N1 is N-1,
                expo(B, N1, R2),
                R is B*R2.


minimo([B], B).
minimo([], !).
minimo([B1,B2|L], R):- 
                    (B1 > B2 ->       
                        minimo([B2|L],R)
                    ; 
                        minimo([B1|L],R)
                    ).
