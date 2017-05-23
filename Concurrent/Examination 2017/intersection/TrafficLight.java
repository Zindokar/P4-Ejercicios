/* examination */
package intersection;
class TrafficLight extends Thread {
    private Street s1, s2;
    private int carNum;
    
    /* se le pasan las dos calles de la intercesión
     y el número de coches a simular que la cruzan */
    public TrafficLight(Street s1, Street s2, int m){
        this.s1 = s1;
        this.s2 = s2;
        this.carNum = m;
    }
    
    public void run () {
        Main.log("Semáforo encendido");
        int cruzados = 0;
        while (cruzados != carNum) { // nos dice que es el número de coches a dar paso
            Main.setOpenStreet(s1);
            for (int i = 0; i < 3; i++) {
                if (cruzados >= carNum) {
                    Main.log("Maximo de coches cruzados alcanzado.");
                    break;
                }
                Main.log("Intento dar paso en calle: " + s1.getName());
                Car car = s1.getCar();
                if (car == null) {
                    Main.log("En la calle: " + s1.getName() + " no hay coches para pasar.");
                    break;
                }
                try {
                    Main.log("Coche curzando en calle: " + s1.getName());
                    Thread.sleep(car.getCrossingTime());
                } catch (InterruptedException e) { }
                Main.log("Coche cruzó en calle: " + s1.getName());
                cruzados++;
            }
            Main.setOpenStreet(s2);
            for (int i = 0; i < 3; i++) {
                if (cruzados >= carNum) {
                    Main.log("Maximo de coches cruzados alcanzado.");
                    break;
                }
                Main.log("Intento dar paso en calle: " + s2.getName());
                Car car = s2.getCar();
                if (car == null) {
                    Main.log("En la calle: " + s2.getName() + " no hay coches para pasar.");
                    break;
                }
                try {
                    Main.log("Coche curzando en calle: " + s2.getName());
                    Thread.sleep(car.getCrossingTime());
                } catch (InterruptedException e) { }
                Main.log("Coche cruzó en calle: " + s2.getName());
                cruzados++;
            }
        }
        Main.log("Coches cruzados: " + cruzados);
        Main.log("Semáforo apagado");
    }
    
}
