#lang racket

;; Fibonacci
(define (fibo N)
  (cond
    ((= N 0) 0)
    ((= N 1) 1)
    (else (+ (- N 1) (fibo (- N 1))))
  )
)

(display (fibo 2))
(newline)
(display (fibo 20))
(newline)