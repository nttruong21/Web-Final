import java.util.Stack;
import java.util.Queue;
import java.util.LinkedList;
public class CheckPalindrome {
    public static boolean useQueue(Queue queue, String str){
        for (int i = str.length()-1; i >=0; i--) {
            queue.add(str.charAt(i));
        }

        String reverse = "";

        while (!queue.isEmpty()) {
            reverse = reverse+queue.remove();
        }
        if (str.equals(reverse))
            return true;
        else
            return false;
    }
    public static boolean useStack(Stack stack, String str)    {
        String reverse = "";
        for (int i = 0; i < str.length(); i++) {
            stack.push(str.charAt(i));
        }
        while (!stack.isEmpty()) {
            reverse = reverse+stack.pop();
        }
        if (str.equals(reverse))
            return true;
        else
            return false;
    }
    public static void main(String[] args) {
        Stack stack = new Stack();
        String str ="12324";
        String str2 ="12321";
        Queue queue = new LinkedList();
        System.out.println("use stack");
        if (useStack(stack, str) == true){
        System.out.println(str+" is a palindrome.");
        }
        else{
        System.out.println(str+" is not a palindrome.");
        }
        System.out.println("\nuse queue");
        if (useQueue(queue, str2) == true){
        System.out.println(str2+" is a palindrome.");
        }
        else{
        System.out.println(str2+" is not a palindrome.");
        }

    }
}

