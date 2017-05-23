package bicing;

public class Usuario extends Thread {
    private int id;
    private Estacion start, end;

    public Usuario (int id, Estacion start, Estacion end) {
        this.id = id;
        this.start = start;
        this.end = end;
    }
    
    public void run () {
        Bicicleta bicicle = start.alquila(id);
        if (bicicle != null) {
            double rideTime = Math.random() * 3000 + 4000;
            Log.paseando(id, end.getId(), (int) rideTime);
            try {
                Thread.sleep((int) rideTime);
            } catch (InterruptedException e) { }
            end.devuelve(id, bicicle);
        }
    }
}