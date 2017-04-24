package textprocessing;

import java.util.*;

public class FileContents {
    private Queue<String> queue;
    private int registerCount = 0;
    private boolean closed = false;
    private int maxFiles, maxChars;
    
    public FileContents(int maxFiles, int maxChars) {
        queue = new LinkedList<>();
        this.maxFiles = maxFiles;
        this.maxChars = maxChars;
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
        if (queue.size() < maxFiles && contents.length() < maxChars) {
            queue.add(contents);
        }
        notifyAll();
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
