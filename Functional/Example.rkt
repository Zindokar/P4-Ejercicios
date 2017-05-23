#lang racket

;; Position of an element in the list, -1 if not inside
(define (pos X L)
    (pos1 X L 0)
)

(define (pos1 X L P)
    (if (null? L)
        -1
        (if (eq? X (car L))
            P
            (pos1 X (cdr L) (+ P 1))
        )
    )
)

(display (pos 'n '(a b c d e f g h i j k l m n o p q r s t u v x y z)))
(newline)

;; Append two lists, L1 + L2
(define (concatena L1 L2)
    (cond
        ((null? L1) L2)
        ((null? L2) L1)
        (else (cons (car L1) (concatena (cdr L1) L2)))
    )
)

(display (concatena '(a b c d) '(e f g h)))
(newline)