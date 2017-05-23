package gofio;
public class Tienda{
    private int capacidad;
    private int stock;
    
    public Tienda(int capacidad){
        this.capacidad = capacidad; 
        this.stock = 0;
    }
    
    public synchronized boolean vender(int idAgricultor, int sacos){ //El agricultor intenta vender N sacos de 20kg
        long fin = System.currentTimeMillis() + ValoresSimulacion.esperaVenta();
        int kilos = sacos * 20;
        Log.intentandoVender(idAgricultor, stock(), kilos, fin - System.currentTimeMillis());
        while (kilos + stock > capacidad && fin - System.currentTimeMillis() > 0) {
            try {
                wait(fin - System.currentTimeMillis());
            } catch (InterruptedException e) { }
        }
        if (kilos + stock > capacidad) {
            Log.noPudoVender(idAgricultor, stock(), kilos);
            return false;
        }
        stock += kilos;
        Log.vendido(idAgricultor, stock(), kilos);
        notifyAll();
        return true;
    }
    
    public synchronized boolean comprar(int idCliente, int kilos){//El cliente intenta comprar N kilos
        long fin = System.currentTimeMillis() + ValoresSimulacion.esperaCompra();
        Log.intentandoComprar(idCliente, stock(), kilos, fin - System.currentTimeMillis());
        while (kilos - stock < 0 && fin - System.currentTimeMillis() > 0) {
            try {
                wait(fin - System.currentTimeMillis());
            } catch (InterruptedException e) { }
        }
        if (kilos - stock > 0) {
            Log.noPudoComprar(idCliente, stock(), kilos);
            return false;
        }
        stock -= kilos;
        Log.comprado(idCliente, stock(), kilos);
        notifyAll();
        return true;
    }
    
    public synchronized int stock(){ //kilos en stock
        return stock;
    }
}
