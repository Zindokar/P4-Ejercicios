package gofio;
public class Cliente extends Thread {
    int id;
    Tienda tienda;
    int comprado;
    
    public Cliente(int id, Tienda t){
        this.id=id;
        this.tienda = t;
        this.comprado = 0;
    }
    public int comprado(){
        return comprado;
    }
    
    public void run () {
        int comprar = ValoresSimulacion.cantidadAComprar();
        boolean comprado = tienda.comprar(id, comprar);
        while (comprado) {
            this.comprado += comprar;
            try {
                Thread.sleep(ValoresSimulacion.tiempoConsumoKilo() * comprar);
            } catch (InterruptedException e) { }
            comprar = ValoresSimulacion.cantidadAComprar();
            comprado = tienda.comprar(id, comprar);
        }
    }
}
