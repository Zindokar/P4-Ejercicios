package textprocessing;
import java.util.*;

public class FileContents {
    private Queue<String> queue;
    private int registerCount = 0;
    private boolean closed = false;
    private int maxFiles, maxChars, fileCount = 0;
    
    public FileContents(int maxFiles, int maxChars) {
        queue = new LinkedList<String>();
        this.maxFiles = maxFiles;
        this.maxChars = maxChars;
    }
    
    public void registerWriter() {
        synchronized (this) {
            registerCount++;
        }
    }
    
    public void unregisterWriter() {
        synchronized (this) {
            registerCount--;
            if (registerCount == 0) {
                closed = true;
            }
        }
    }
    
    public void addContents(String contents) {
        synchronized (this) {
            if (fileCount <= maxFiles && contents.length() <= maxChars) {
                queue.add(contents);
                fileCount++;
            }
        }
    }
    
    public String getContents() {
        synchronized (this) {
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
}
