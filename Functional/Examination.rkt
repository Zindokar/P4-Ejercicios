#lang racket

;given

;rdc devuelve una lista igual que la pasada, pero sin el último elemento
(define (rdc L)
    (if (null? (cdr L))
        '()
        (cons (car L) (rdc (cdr L)))
    )
)
;rac devuelve último elemento de la lista
(define (rac L)
    (if (null? (cdr L))
        (car L)
        (rac (cdr L) )
    )
)

;Use display para utilizar casos de prueba particulares

;examination

;; 1) Ordenado
(define (ordenado? L)
    (cond
        ((null? L) #t)
        (else (ordenadoAux (cdr L) (car L)))
    )
)

;; Inmersion para 'ordenado?'
(define (ordenadoAux L N)
    (cond
        ((null? L) #t)
        ((<= N (car L)) (ordenadoAux (cdr L) (car L)))
        (else #f)
    )
)

;; 2) Capicúa
(define (capicua? L)
    (cond
        ((null? L) #t)
        (else (capicuaAux L L))
    )
)

;; Inmersión para 'capicua?'
(define (capicuaAux L1 L2)
    (cond
        ((null? L1) #t)
        ((null? L2) #t)
        ((eqv? (car L1) (rac L2)) (capicuaAux (cdr L1) (rdc L2)))
        (else #f)
    )
)

;; 3) Últimos
(define (ultimos L N)
    (cond
        ((null? L) '())
        ((<= N 0) L)
        (else (ultimos (cdr L) (- N 1)))
    )
)
