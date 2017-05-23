/* examination */
package intersection;
import java.util.*;
class Street {
    private String name;
    private Queue<Car> carList;
    /* Se le pasa nombre de calle y
    establece la cola vacía */
    public Street(String name){
        this.name = name;
        this.carList = new LinkedList<>();
    }

    /* Devuelve nombre de calle */
    public String getName(){
        return name;
    }

    /* Añade un coche a la cola. Lo usa la clase CarGenerator */
    public synchronized void addCar(Car c) {
        this.carList.add(c);
        notifyAll();
    }
    
    /* Devuelve y saca un coche de la cola
     * devuelve null en la version avanzada si espera mas de 2 segs
     */
    public synchronized Car getCar() {
        Car car = carList.poll();
        long fin = System.currentTimeMillis() + 2000;
        while (fin - System.currentTimeMillis() > 0 && car == null) {
            try {
                wait(fin - System.currentTimeMillis());
            } catch (InterruptedException e) { }
            car = carList.poll();
        }
        if (car == null) {
            return null;
        }
        return car;
    }

    /* Devuelve un array con los coche de la cola y en su orden*/
    public synchronized Car[] getAllCars(){
        return carList.toArray(new Car[0]);
    }
}