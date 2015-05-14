package com.frba.abclandia;

import android.app.Activity;
import android.app.FragmentManager;
import android.content.Intent;
import android.graphics.Color;
import android.graphics.drawable.GradientDrawable;
import android.os.Bundle;
import android.view.View;
import android.view.Window;
import android.view.WindowManager;
import android.widget.Button;

import com.example.abclandia.GameActivity;
import com.example.abclandia.GameDataStructure;
import com.example.abclandia.GameSixActivity;
import com.frba.abclandia.NivelesDialogFragment.DialogLevelListener;

public class JugarActivity extends Activity 
		implements View.OnClickListener, DialogLevelListener{
	private Button btnEjercicio1, btnEjercicio2, btnEjercicio3,
			btnEjercicio4, btnEjercicio5, btnEjercicio6;
	private View mLayout;
	
	private Class<?> exerciseClass;
	


	@Override
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		
		requestWindowFeature(Window.FEATURE_NO_TITLE);
		getWindow().setFlags(WindowManager.LayoutParams.FLAG_FULLSCREEN, 
		WindowManager.LayoutParams.FLAG_FULLSCREEN);
		setContentView(R.layout.ejercicios_activity);
		
		mLayout = findViewById(R.id.layoutJuegoActivity);
		btnEjercicio1 = (Button) findViewById(R.id.btnEjercicio1);
		btnEjercicio2 = (Button) findViewById(R.id.btnEjercicio2);
		btnEjercicio3 = (Button) findViewById(R.id.btnEjercicio3);
		btnEjercicio4 = (Button) findViewById(R.id.btnEjercicio4);
		btnEjercicio5 = (Button) findViewById(R.id.btnEjercicio5);
		btnEjercicio6 = (Button) findViewById(R.id.btnEjercicio6);
		
		btnEjercicio1.setOnClickListener(this);
		btnEjercicio2.setOnClickListener(this);
		btnEjercicio3.setOnClickListener(this);
		btnEjercicio4.setOnClickListener(this);
		btnEjercicio5.setOnClickListener(this);
		btnEjercicio6.setOnClickListener(this);
		
		((GradientDrawable) btnEjercicio1.getBackground()).setColor(Color.parseColor("#AC92ED"));
		((GradientDrawable) btnEjercicio2.getBackground()).setColor(Color.parseColor("#48CFAE"));
		((GradientDrawable) btnEjercicio3.getBackground()).setColor(Color.parseColor("#FFCE55"));
		((GradientDrawable) btnEjercicio4.getBackground()).setColor(Color.parseColor("#A0D468"));
		((GradientDrawable) btnEjercicio5.getBackground()).setColor(Color.parseColor("#4FC0E8"));
		((GradientDrawable) btnEjercicio6.getBackground()).setColor(Color.parseColor("#FB6E52"));
			     
	}

	@Override
	public void onClick(View v) {
		int exerciseNumber = 0;
		if (v == btnEjercicio1){
			exerciseNumber = 1;
		}
		if (v == btnEjercicio2){
			exerciseNumber = 2;
		}
		if (v == btnEjercicio3){
			exerciseNumber = 3;
		}
		if (v == btnEjercicio4){
			exerciseNumber = 4;
		}
		if (v == btnEjercicio5){
			exerciseNumber = 5;
		}
		if (v == btnEjercicio6){
			Intent intent = new Intent(this, GameSixActivity.class);
			intent.putExtra(GameActivity.INTENT_LEVEL_KEY, 1);
			intent.putExtra(GameActivity.INTENT_SECUENCE_KEY, 1);
			
			startActivity(intent);
			return;
			
		}
		
		exerciseClass = GameDataStructure.getExerciseClass(exerciseNumber);
		

		
		FragmentManager fm = getFragmentManager();
        NivelesDialogFragment editNameDialog = new NivelesDialogFragment();
      
        editNameDialog.show(fm, "fragment_edit_name");
        
		
		
		
	}





	@Override
	public void onChooseLevel(int levelNumber) {
		Intent intent = new Intent(this, exerciseClass);
		intent.putExtra(GameActivity.INTENT_LEVEL_KEY, levelNumber);
		intent.putExtra(GameActivity.INTENT_SECUENCE_KEY, 1);
		
		
		startActivity(intent);
		finish();
		
	}
	
}
