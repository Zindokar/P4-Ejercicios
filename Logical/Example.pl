padre(juan, pepe).
padre(juan, ana).
padre(juan, antonio).
padre(antonio, elena).
padre(antonio, juana).
padre(antonio, carlos).
padre(juan, beatriz).
abuelo(Abuelo, Nieto) :-padre(Abuelo, Padre), padre(Padre, Nieto).

