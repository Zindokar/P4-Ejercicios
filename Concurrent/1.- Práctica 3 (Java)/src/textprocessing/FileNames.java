package textprocessing;
import java.util.*;
public class FileNames {
    private Queue<String> queue;
    private boolean flag;
    
    public FileNames() {
        queue = new LinkedList<String>();
        flag = true;
    }
    
    public void addName(String fileName) {
        queue.add(fileName);
        notify();
    }
    
    public String getName() {
        synchronized (this) {
            if (!flag) {
                return null;
            }
            String element = queue.poll();
            if (element != null) {
                return element;
            }
            try {
                wait();
            } catch (InterruptedException e) {}
            return queue.poll();
        }
    }
    
    public void noMoreNames() {
        flag = false;   
    }
}