package textprocessing;

import java.util.*;

public class FileContents {
    private Queue<String> queue;
    private int registerCount = 0;
    private boolean closed = false;
    private int maxFiles, maxChars, currentChars;
    
    public FileContents(int maxFiles, int maxChars) {
        queue = new LinkedList<>();
        this.maxFiles = maxFiles;
        this.maxChars = maxChars;
        this.currentChars = 0;
    }
    
    public synchronized void registerWriter() {
        registerCount++;
    }
    
    public synchronized void unregisterWriter() {
        registerCount--;
        if (registerCount == 0) {
            closed = true;
        }
    }
    
    public synchronized void addContents(String contents) {
        if (queue.size() < maxFiles && currentChars < maxChars) {
            currentChars += contents.length();
            queue.add(contents);
            notifyAll(); // Sólo notifico si he introducido un dato correctamente
        }
    }
    
    public synchronized String getContents() {
        if (closed) {
            return null;
        }
        String text = queue.poll();
        if (text != null) {
            return text;
        }
        try {
            wait();
        } catch (InterruptedException e) {}
        return queue.poll();
    }
}
