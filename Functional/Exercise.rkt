#lang racket

;; 1.- Fibonacci
(define (fibo N)
    (cond
        ((<= N 0) 0)
        ((= N 1) 1)
        (else (+ (fibo (- N 1)) (fibo (- N 2))))
    )
)

;; 2.- Exponente
(define (expo B E)
    (cond
        ((= E 0) 1)
        ((= E 1) B)
        (else (* B (expo B (- E 1))))
    )
)

;; 3.- Mínimo de una lista
(define (minimo L)
    (cond
        ((null? L) null)
        (else (minimoInmersion (cdr L) (car L)))
    )
)

;; Función de inmersión para el 3.
(define (minimoInmersion L N)
    (cond
        ((null? L) N)
        ((< (car L) N) (minimoInmersion (cdr L) (car L)))
        (else (minimoInmersion (cdr L) N))
    )
)

;; 4.- Insertar en una lista en orden
(define (inserta N L)
    (cond
        ((null? L) (cons N '()))
        ((> N (car L)) (cons (car L) (inserta N (cdr L))))
        (else (cons N (inserta (car L) (cdr L))))
    )
)

;; 5.- Concatenar dos listas, L1 y L2
(define (concatena L1 L2)
    (cond
        ((null? L1) L2)
        ((null? L2) L1)
        (else (cons (car L1) (concatena (cdr L1) L2)))
    )
)

;; 6.- Invertir una lista
(define (invierte L)
    (cond
        ((null?  L) '())
        (else (concatena (invierte (cdr L)) (cons (car L) '())))
    )
)

;; 7.- Elimina un elemento dado por parámetro de la lista
(define (elimina E L)
    (cond
        ((null? L) '())
        ((equal? E (car L)) (elimina E (cdr L)))
        (else (cons (car L) (elimina E (cdr L))))
    )
)