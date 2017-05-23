package bicing;
import java.util.*;
public class Estacion {
    
    private int id;
    private int capacity;
    private Queue<Bicicleta> parking;
    
    public Estacion (int id, int capacity) {
        Log.creandoEstación(id, capacity);
        this.id = id;
        this.capacity = capacity;
        this.parking = new LinkedList<>();
        for (int i = 0; i < this.capacity; i++) {
            this.parking.add(new Bicicleta(this.id * 1000 + i));
        }
    }
    
    public int getId() {
        return id;
    }
    
    public synchronized Bicicleta alquila(int id) {
        Log.intentandoAlquilar(id, getId());
        Bicicleta currentBicicle = parking.poll();
        long end = System.currentTimeMillis() + 10000;
        while (currentBicicle == null && end - System.currentTimeMillis() > 0) {
            Log.esperandoAlquilar(id, getId(), end - System.currentTimeMillis());
            try {
                wait(end - System.currentTimeMillis());
            } catch (InterruptedException e) { }
            currentBicicle = parking.poll();
        }
        if (currentBicicle == null) {
            Log.abandona(id, getId());
        } else {
            Log.alquila(id, getId(), currentBicicle.getId());
            notifyAll();
        }
        return currentBicicle;
    }
    
    public synchronized void devuelve(int id, Bicicleta bicicle) {
        Log.intentandoDevolver(id, getId(), bicicle.getId());
        while (this.capacity == parking.size()) {
            try {
                wait();
            } catch (InterruptedException e) { }
        }
        parking.add(bicicle);
        notifyAll();
        Log.devuelve(id, getId(), bicicle.getId());
    }
    
}