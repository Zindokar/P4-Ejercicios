package gofio;
public class Agricultor extends Thread{
    int id;
    Tienda tienda;
    int vendido;
    
    public Agricultor(int id, Tienda t){
        this.id=id;
        this.tienda = t;
        this.vendido = 0;
    }
    
    public int vendido(){ 
        // RETORNAR nº de Kg
        return vendido * 20; 
    }
    
    public void run () {
        for (int i = 0; i < 5; i++) {
            int cosechado = ValoresSimulacion.cantidadCosechada();
            if (tienda.vender(id, cosechado)) {
                vendido += cosechado;
            }
            try {
                Thread.sleep(ValoresSimulacion.tiempoCosecha());
            } catch (InterruptedException e) { }
        }
    }
}
