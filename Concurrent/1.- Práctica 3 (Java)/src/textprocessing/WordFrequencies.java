package textprocessing;
import java.util.Map;
import java.util.HashMap;

public class WordFrequencies {

    private Map<String,Integer> frequencies;

    public WordFrequencies() {
        frequencies = new HashMap<String, Integer>();
    }

    public synchronized void addFrequencies(Map<String,Integer> f){
        frequencies.putAll(f);
    }
    
    public Map<String,Integer> getFrequencies(){
        return frequencies;
    }
}
